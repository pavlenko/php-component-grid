<?php

namespace PE\Component\Grid;

use PE\Component\Grid\ColumnExtension\ColumnExtensionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\GridExtension\GridExtensionInterface;

interface RegistryInterface
{
    /**
     * @param string $name
     *
     * @return ResolvedGridTypeInterface
     *
     * @throws InvalidArgumentException
     */
    public function getGridType($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasGridType($name);

    /**
     * @return GridExtensionInterface[]
     */
    public function getGridExtensions();

    /**
     * @param string $name
     *
     * @return ResolvedColumnTypeInterface
     *
     * @throws InvalidArgumentException
     */
    public function getColumnType($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasColumnType($name);

    /**
     * @return ColumnExtensionInterface[]
     */
    public function getColumnExtensions();
}