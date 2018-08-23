<?php

namespace PE\Component\Grid\GridType;

use PE\Component\Grid\GridBuilderInterface;
use PE\Component\Grid\GridInterface;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;
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
     * @param RowView       $view
     * @param GridInterface $grid
     * @param array         $options
     */
    public function buildRowView(RowView $view, GridInterface $grid, array $options);

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * @return string
     */
    public function getBlockPrefix();

    /**
     * @return string|null
     */
    public function getParent();
}