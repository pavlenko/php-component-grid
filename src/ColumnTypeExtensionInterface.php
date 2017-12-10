<?php

namespace PE\Component\Grid;

use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\HeaderView;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ColumnTypeExtensionInterface
{
    /**
     * @param HeaderView      $view
     * @param ColumnInterface $column
     * @param array           $options
     */
    public function buildHeaderView(HeaderView $view, ColumnInterface $column, array $options);

    /**
     * @param CellView        $view
     * @param ColumnInterface $column
     * @param array           $options
     */
    public function buildCellView(CellView $view, ColumnInterface $column, array $options);

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * @return string
     */
    public function getExtendedType();
}