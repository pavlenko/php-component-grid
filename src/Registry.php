<?php

namespace PE\Component\Grid;

use PE\Component\Grid\ColumnExtension\ColumnExtensionInterface;
use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\GridExtension\GridExtensionInterface;
use PE\Component\Grid\GridType\GridTypeInterface;

class Registry implements RegistryInterface
{
    /**
     * @var ResolvedGridTypeInterface[]
     */
    protected $gridTypes = [];

    /**
     * @var GridExtensionInterface[]
     */
    protected $gridExtensions = [];

    /**
     * @var ResolvedColumnTypeInterface[]
     */
    protected $columnTypes = [];

    /**
     * @var ColumnExtensionInterface[]
     */
    protected $columnExtensions = [];

    /**
     * Constructor
     *
     * @param GridExtensionInterface[]   $gridExtensions
     * @param ColumnExtensionInterface[] $columnExtensions
     *
     * @throws InvalidArgumentException If extension is invalid
     */
    public function __construct(array $gridExtensions, array $columnExtensions)
    {
        foreach ($gridExtensions as $gridExtension) {
            if (!($gridExtension instanceof GridExtensionInterface)) {
                throw new InvalidArgumentException(
                    'Grid extension must be instance of ' . GridExtensionInterface::class
                );
            }
        }

        foreach ($columnExtensions as $columnExtension) {
            if (!($columnExtension instanceof ColumnExtensionInterface)) {
                throw new InvalidArgumentException(
                    'Column extension must be instance of ' . ColumnExtensionInterface::class
                );
            }
        }

        $this->gridExtensions   = $gridExtensions;
        $this->columnExtensions = $columnExtensions;
    }

    /**
     * @inheritDoc
     */
    public function getGridType($name)
    {
        if (!array_key_exists($name, $this->gridTypes)) {
            $type = null;

            foreach ($this->gridExtensions as $extension) {
                if ($extension->hasType($name)) {
                    $type = $extension->getType($name);
                    break;
                }
            }

            if (!$type) {
                // Support fully-qualified class names
                if (
                    class_exists($name) &&
                    in_array(GridTypeInterface::class, class_implements($name), false)
                ) {
                    $type = new $name();
                } else {
                    throw new InvalidArgumentException(sprintf('Could not load type "%s"', $name));
                }
            }

            $this->gridTypes[$name] = $this->resolveGridType($type);
        }

        return $this->gridTypes[$name];
    }

    /**
     * @inheritDoc
     */
    public function hasGridType($name)
    {
        if (array_key_exists($name, $this->gridTypes)) {
            return true;
        }

        try {
            $this->getGridType($name);
        } catch (ExceptionInterface $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getGridExtensions()
    {
        return $this->gridExtensions;
    }

    /**
     * @param GridTypeInterface $type
     *
     * @return ResolvedGridTypeInterface
     *
     * @throws InvalidArgumentException
     */
    protected function resolveGridType(GridTypeInterface $type)
    {
        $typeExtensions = [];
        $parentType     = $type->getParent();
        $fqcn           = get_class($type);

        foreach ($this->gridExtensions as $extension) {
            $typeExtensions = array_merge(
                $typeExtensions,
                $extension->getTypeExtensions($fqcn)
            );
        }

        return new ResolvedGridType($type, $typeExtensions, $parentType ? $this->getGridType($parentType) : null);
    }

    /**
     * @inheritDoc
     */
    public function getColumnType($name)
    {
        if (!array_key_exists($name, $this->columnTypes)) {
            $type = null;

            foreach ($this->columnExtensions as $extension) {
                if ($extension->hasType($name)) {
                    $type = $extension->getType($name);
                    break;
                }
            }

            if (!$type) {
                // Support fully-qualified class names
                if (
                    class_exists($name) &&
                    in_array(ColumnTypeInterface::class, class_implements($name), false)
                ) {
                    $type = new $name();
                } else {
                    throw new InvalidArgumentException(sprintf('Could not load type "%s"', $name));
                }
            }

            $this->columnTypes[$name] = $this->resolveColumnType($type);
        }

        return $this->columnTypes[$name];
    }

    /**
     * @inheritDoc
     */
    public function hasColumnType($name)
    {
        if (array_key_exists($name, $this->columnTypes)) {
            return true;
        }

        try {
            $this->getColumnType($name);
        } catch (ExceptionInterface $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getColumnExtensions()
    {
        return $this->columnExtensions;
    }

    /**
     * @param ColumnTypeInterface $type
     *
     * @return ResolvedColumnTypeInterface
     *
     * @throws InvalidArgumentException
     */
    protected function resolveColumnType(ColumnTypeInterface $type)
    {
        $typeExtensions = [];
        $parentType     = $type->getParent();
        $fqcn           = get_class($type);

        foreach ($this->columnExtensions as $extension) {
            $typeExtensions = array_merge(
                $typeExtensions,
                $extension->getTypeExtensions($fqcn)
            );
        }

        return new ResolvedColumnType($type, $typeExtensions, $parentType ? $this->getColumnType($parentType) : null);
    }
}