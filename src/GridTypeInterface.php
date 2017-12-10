<?php

namespace PE\Component\Grid;

use PE\Component\Grid\View\GridView;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface GridTypeInterface
{
    /**
     * @param GridBuilderInterface $builder
     * @param array                $options
     */
    public function buildGrid(GridBuilderInterface $builder, array $options);

    /**
     * @param GridView      $view
     * @param GridInterface $grid
     * @param array         $options
     */
    public function buildGridView(GridView $view, GridInterface $grid, array $options);

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getParent();
}