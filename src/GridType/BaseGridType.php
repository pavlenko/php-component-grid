<?php

namespace PE\Component\Grid\GridType;

use PE\Component\Grid\GridInterface;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseGridType extends AbstractGridType
{
    /**
     * @inheritDoc
     */
    public function buildGridView(GridView $view, GridInterface $grid, array $options)
    {
        $blockPrefixes = [];
        for ($type = $grid->getType(); null !== $type; $type = $type->getParent()) {
            array_unshift($blockPrefixes, $type->getBlockPrefix());
        }

        $view->vars = array_replace($view->vars, [
            'grid'           => $view,
            'id'             => uniqid() . '_' . $view->name,
            'name'           => $view->name,
            'block_prefixes' => $blockPrefixes,
            'attr'           => $options['attr'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function buildRowView(RowView $view, GridInterface $grid, array $options)
    {
        $blockPrefixes = [];
        for ($type = $grid->getType(); null !== $type; $type = $type->getParent()) {
            array_unshift($blockPrefixes, $type->getBlockPrefix());
        }

        $view->vars = array_replace($view->vars, [
            'grid'           => $view->grid,
            'row'            => $view,
            'block_prefixes' => $blockPrefixes,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => [],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return null;
    }
}