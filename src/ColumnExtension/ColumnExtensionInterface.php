<?php

namespace PE\Component\Grid\ColumnExtension;

use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\ColumnTypeExtension\ColumnTypeExtensionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;

interface ColumnExtensionInterface
{
    /**
     * @param string $name
     *
     * @return ColumnTypeInterface
     *
     * @throws InvalidArgumentException
     */
    public function getType($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasType($name);

    /**
     * @param string $name
     *
     * @return ColumnTypeExtensionInterface[]
     */
    public function getTypeExtensions($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasTypeExtensions($name);
}