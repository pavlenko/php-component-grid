<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\ColumnView;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ColumnTypeInterface
{
    /**
     * @param ColumnView      $view
     * @param ColumnInterface $column
     * @param array           $options
     */
    public function buildColumnView(ColumnView $view, ColumnInterface $column, array $options);

    /**
     * @param CellView        $view
     * @param ColumnInterface $column
     * @param mixed           $row
     * @param array           $options
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options);

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * @return string
     */
    public function getBlockPrefix();

    /**
     * @return string|null
     */
    public function getParent();
}