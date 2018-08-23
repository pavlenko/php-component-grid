<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Change enumerable "status" column
 */
class StatusColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'multiple' => $options['multiple'],
            'choices'  => $options['choices'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'multiple' => false,
            'choices'  => null,
        ]);

        $resolver->setAllowedTypes('multiple', ['bool']);
        $resolver->setAllowedTypes('choices', ['array']);
    }
}