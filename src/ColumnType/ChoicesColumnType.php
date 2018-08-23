<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Selected choice(s) column
 */
class ChoicesColumnType extends AbstractColumnType
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
            'choices'  => null,//TODO choice loader, support grouped choices, choice list class
            'multiple' => false,
        ]);

        $resolver->setAllowedTypes('multiple', ['bool']);
        $resolver->setAllowedTypes('choices', ['array']);
    }
}