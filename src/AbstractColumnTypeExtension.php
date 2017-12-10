<?php

namespace PE\Component\Grid;

use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\HeaderView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractColumnTypeExtension implements ColumnTypeExtensionInterface
{
    /**
     * @inheritDoc
     */
    public function buildHeaderView(HeaderView $view, ColumnInterface $column, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {}
}