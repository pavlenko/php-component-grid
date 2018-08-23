<?php

namespace PE\Component\Grid\ColumnTypeExtension;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\ColumnView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractColumnTypeExtension implements ColumnTypeExtensionInterface
{
    /**
     * @inheritDoc
     */
    public function buildColumnView(ColumnView $view, ColumnInterface $column, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {}
}