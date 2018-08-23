<?php

namespace PE\Component\Grid\GridTypeExtension;

use PE\Component\Grid\GridBuilderInterface;
use PE\Component\Grid\GridInterface;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;
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
    public function buildRowView(RowView $view, GridInterface $grid, array $options)
    {}

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {}
}