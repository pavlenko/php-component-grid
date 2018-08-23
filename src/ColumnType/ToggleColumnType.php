<?php

namespace PE\Component\Grid\ColumnType;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Change boolean value column
 */
class ToggleColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'url' => null,
        ]);
    }
}