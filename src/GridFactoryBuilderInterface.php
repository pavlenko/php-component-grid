<?php

namespace PE\Component\Grid;

use PE\Component\Grid\ColumnExtension\ColumnExtensionInterface;
use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\ColumnTypeExtension\ColumnTypeExtensionInterface;
use PE\Component\Grid\GridExtension\GridExtensionInterface;
use PE\Component\Grid\GridType\GridTypeInterface;
use PE\Component\Grid\GridTypeExtension\GridTypeExtensionInterface;

interface GridFactoryBuilderInterface
{
    /**
     * @param GridExtensionInterface $extension
     *
     * @return self
     */
    public function addGridExtension(GridExtensionInterface $extension);

    /**
     * @param GridTypeInterface $type
     *
     * @return self
     */
    public function addGridType(GridTypeInterface $type);

    /**
     * @param GridTypeExtensionInterface $extension
     *
     * @return self
     */
    public function addGridTypeExtension(GridTypeExtensionInterface $extension);

    /**
     * @param ColumnExtensionInterface $extension
     *
     * @return self
     */
    public function addColumnExtension(ColumnExtensionInterface $extension);

    /**
     * @param ColumnTypeInterface $type
     *
     * @return self
     */
    public function addColumnType(ColumnTypeInterface $type);

    /**
     * @param ColumnTypeExtensionInterface $extension
     *
     * @return self
     */
    public function addColumnTypeExtension(ColumnTypeExtensionInterface $extension);

    /**
     * @return GridFactoryInterface
     */
    public function getGridFactory();
}