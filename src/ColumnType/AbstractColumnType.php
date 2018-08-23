<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\ColumnView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractColumnType implements ColumnTypeInterface
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

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        // Taken from Symfony\Component\Form\Util\StringUtil
        // Non-greedy ("+?") to match "ColumnType" suffix, if present
        if (preg_match('~([^\\\\]+?)(ColumnType)?$~i', get_class($this), $matches)) {
            return strtolower(preg_replace(
                ['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'],
                ['\\1_\\2', '\\1_\\2'],
                $matches[1]
            ));
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return BaseColumnType::class;
    }
}