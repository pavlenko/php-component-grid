<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Boolean value column
 */
class BooleanColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'label_true'  => $options['label_true'],
            'label_false' => $options['label_false'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label_true'  => 'Yes',
            'label_false' => 'No',
        ]);

        $resolver->setAllowedTypes('label_true', ['string']);
        $resolver->setAllowedTypes('label_false', ['string']);
    }
}