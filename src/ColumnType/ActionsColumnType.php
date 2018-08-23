<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\View\CellView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Row actions column
 */
class ActionsColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'actions' => $options['actions'],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped'  => false,
            'actions' => [],
        ]);

        $resolver->setAllowedTypes('actions', ['array']);

        // Inner action resolver to use in extensions
        $resolver->setDefault('action_resolver', function (Options $options) {
            $actionResolver = new OptionsResolver();
            $actionResolver->setDefaults([
                'label' => null,
                'url'   => null,
                'tag'   => 'a',
                'attr'  => [],
            ]);

            return $actionResolver;
        });

        // Post process actions
        $resolver->setNormalizer('actions', function (Options $resolver, $value) {
            foreach ($value as $key => $item) {
                $value[$key] = $resolver['action_resolver']->resolve($item);
            }

            return $value;
        });
    }
}