<?php

namespace PE\Component\Grid\ColumnExtension;

use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\ColumnTypeExtension\ColumnTypeExtensionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\UnexpectedValueException;

abstract class AbstractColumnExtension implements ColumnExtensionInterface
{
    /**
     * @var null|array
     */
    private $types;

    /**
     * @var null|array
     */
    private $typeExtensions;

    /**
     * @inheritDoc
     */
    public function getType($name)
    {
        if (null === $this->types) {
            $this->initTypes();
        }

        if (!isset($this->types[$name])) {
            throw new InvalidArgumentException(sprintf(
                'The type "%s" can not be loaded by this extension',
                $name
            ));
        }

        return $this->types[$name];
    }

    /**
     * @inheritDoc
     */
    public function hasType($name)
    {
        if (null === $this->types) {
            $this->initTypes();
        }

        return isset($this->types[$name]);
    }

    /**
     * @inheritDoc
     */
    public function getTypeExtensions($name)
    {
        if (null === $this->typeExtensions) {
            $this->initTypeExtensions();
        }

        return isset($this->typeExtensions[$name])
            ? $this->typeExtensions[$name]
            : [];
    }

    /**
     * @inheritDoc
     */
    public function hasTypeExtensions($name)
    {
        if (null === $this->typeExtensions) {
            $this->initTypeExtensions();
        }

        return isset($this->typeExtensions[$name]) && count($this->typeExtensions[$name]) > 0;
    }

    private function initTypes()
    {
        $this->types = [];

        foreach ($this->loadTypes() as $type) {
            if (!($type instanceof ColumnTypeInterface)) {
                throw new UnexpectedValueException($type, ColumnTypeInterface::class);
            }

            $this->types[get_class($type)] = $type;
        }
    }

    private function initTypeExtensions()
    {
        $this->typeExtensions = [];

        foreach ($this->loadTypeExtensions() as $extension) {
            if (!($extension instanceof ColumnTypeExtensionInterface)) {
                throw new UnexpectedValueException($extension, ColumnTypeExtensionInterface::class);
            }

            $this->typeExtensions[$extension->getExtendedType()][] = $extension;
        }
    }

    /**
     * @return ColumnTypeInterface[]
     */
    protected function loadTypes()
    {
        return [];
    }

    /**
     * @return ColumnTypeExtensionInterface[]
     */
    protected function loadTypeExtensions()
    {
        return [];
    }
}