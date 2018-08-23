<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\ColumnView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    public function buildColumnView(ColumnView $view, ColumnInterface $column, array $options)
    {
        $blockPrefixes = [];
        for ($type = $column->getType(); null !== $type; $type = $type->getParent()) {
            array_unshift($blockPrefixes, $type->getBlockPrefix());
        }

        $view->vars = array_replace($view->vars, [
            'grid'               => $view->grid,
            'column'             => $view,
            'id'                 => $view->grid->vars['id'] . '_' . $column->getName(),
            'name'               => $column->getName(),
            'type'               => $column->getType()->getBlockPrefix(),
            'block_prefixes'     => $blockPrefixes,
            'label'              => $options['label'],
            'translation_domain' => $options['translation_domain'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options)
    {
        $blockPrefixes = [];
        for ($type = $column->getType(); null !== $type; $type = $type->getParent()) {
            array_unshift($blockPrefixes, $type->getBlockPrefix());
        }

        $view->vars = array_replace($view->vars, [
            'grid'               => $view->grid,
            'cell'               => $view,
            'id'                 => $view->grid->vars['id'] . '_' . $column->getName() . '_1',//TODO use row index as id suffix
            'name'               => $column->getName(),
            'block_prefixes'     => $blockPrefixes,
            'label'              => $options['label'],
            'translation_domain' => $options['translation_domain'],
            'value'              => $view->vars['value'] ?? null,
            'attr'               => $options['attr'],
            'property_path'      => $options['property_path'] ?? $view->name,//TODO are this need
        ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'property_path'      => null,
            'mapped'             => true,
            'label'              => null,
            'attr'               => [],
            'translation_domain' => null,
        ]);

        $resolver->setAllowedTypes('property_path', ['null', 'string']);
        $resolver->setAllowedTypes('label', ['null', 'string']);
        $resolver->setAllowedTypes('attr', ['array']);
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return null;
    }
}