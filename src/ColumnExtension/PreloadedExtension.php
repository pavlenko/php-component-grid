<?php

namespace PE\Component\Grid\ColumnExtension;

use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\ColumnTypeExtension\ColumnTypeExtensionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;

class PreloadedExtension implements ColumnExtensionInterface
{
    /**
     * @var ColumnTypeInterface[]
     */
    private $types = [];

    /**
     * @var ColumnTypeExtensionInterface[][]
     */
    private $typeExtensions = [];

    /**
     * @param ColumnTypeInterface[]            $types
     * @param ColumnTypeExtensionInterface[][] $typeExtensions
     */
    public function __construct(array $types, array $typeExtensions)
    {
        $this->typeExtensions = $typeExtensions;

        foreach ($types as $type) {
            $this->types[get_class($type)] = $type;
        }
    }

    /**
     * @inheritDoc
     */
    public function getType($name)
    {
        if (!isset($this->types[$name])) {
            throw new InvalidArgumentException(sprintf('The type "%s" can not be loaded by this extension', $name));
        }

        return $this->types[$name];
    }

    /**
     * @inheritDoc
     */
    public function hasType($name)
    {
        return isset($this->types[$name]);
    }

    /**
     * @inheritDoc
     */
    public function getTypeExtensions($name)
    {
        return isset($this->typeExtensions[$name])
            ? $this->typeExtensions[$name]
            : array();
    }

    /**
     * @inheritDoc
     */
    public function hasTypeExtensions($name)
    {
        return !empty($this->typeExtensions[$name]);
    }
}