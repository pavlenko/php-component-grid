<?php

namespace PE\Component\Grid;

use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\ColumnView;
use PE\Component\Grid\View\GridView;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ResolvedColumnTypeInterface
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ColumnInterface
     */
    public function createColumn($name, array $options);

    /**
     * @param GridView $grid
     * @param string   $name
     *
     * @return ColumnView
     */
    public function createColumnView(GridView $grid, $name);

    /**
     * @param ColumnView      $view
     * @param ColumnInterface $column
     * @param array           $options
     */
    public function buildColumnView(ColumnView $view, ColumnInterface $column, array $options);

    /**
     * @param GridView $grid
     * @param string   $name
     *
     * @return CellView
     */
    public function createCellView(GridView $grid, $name);

    /**
     * @param CellView        $view
     * @param ColumnInterface $column
     * @param mixed           $row
     * @param array           $options
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options);

    /**
     * @return OptionsResolver
     */
    public function getOptionsResolver();

    /**
     * @return ColumnTypeInterface
     */
    public function getInnerType();

    /**
     * @return self|null
     */
    public function getParent();

    /**
     * @return string|null
     */
    public function getBlockPrefix();
}