<?php

namespace PE\Component\Grid;

use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\HeaderView;
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
     * @param ColumnInterface $column
     *
     * @return HeaderView
     */
    public function createHeaderView(ColumnInterface $column);

    /**
     * @param HeaderView      $view
     * @param ColumnInterface $column
     * @param array           $options
     */
    public function buildHeaderView(HeaderView $view, ColumnInterface $column, array $options);

    /**
     * @param ColumnInterface $column
     *
     * @return CellView
     */
    public function createCellView(ColumnInterface $column);

    /**
     * @param CellView        $view
     * @param ColumnInterface $column
     * @param array           $options
     */
    public function buildCellView(CellView $view, ColumnInterface $column, array $options);

    /**
     * @return OptionsResolver
     */
    public function getOptionsResolver();

    /**
     * @return ColumnTypeInterface
     */
    public function getInnerType();
}