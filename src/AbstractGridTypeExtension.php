<?php

namespace PE\Component\Grid;

use PE\Component\Grid\View\GridView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractGridTypeExtension implements GridTypeExtensionInterface
{
    /**
     * @inheritDoc
     */
    public function buildGrid(GridBuilderInterface $builder, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function buildGridView(GridView $view, GridInterface $grid, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {}
}