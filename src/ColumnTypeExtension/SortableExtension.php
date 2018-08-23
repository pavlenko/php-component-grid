<?php

namespace PE\Component\Grid\ColumnTypeExtension;

use PE\Component\Grid\ColumnTypeExtension\AbstractColumnTypeExtension;
use PE\Component\Grid\ColumnType\StringColumnType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortableExtension extends AbstractColumnTypeExtension
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        //TODO other options
        $resolver->setDefaults([
            'sortable' => true,
        ]);

        $resolver->setAllowedTypes('sortable', 'boolean');
    }

    /**
     * @inheritDoc
     */
    public function getExtendedType()
    {
        return StringColumnType::class;
    }
}