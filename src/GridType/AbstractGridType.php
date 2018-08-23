<?php

namespace PE\Component\Grid\GridType;

use PE\Component\Grid\GridBuilderInterface;
use PE\Component\Grid\GridInterface;
use PE\Component\Grid\GridType\GridTypeInterface;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractGridType implements GridTypeInterface
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

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        // Taken from Symfony\Component\Form\Util\StringUtil
        // Non-greedy ("+?") to match "GridType" suffix, if present
        if (preg_match('~([^\\\\]+?)(GridType)?$~i', get_class($this), $matches)) {
            return strtolower(preg_replace(
                ['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'],
                ['\\1_\\2', '\\1_\\2'],
                $matches[1]
            ));
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return BaseGridType::class;
    }
}