<?php

namespace PE\Component\Grid;

use PE\Component\Grid\GridType\GridTypeInterface;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ResolvedGridTypeInterface
{
    /**
     * @param RegistryInterface $registry
     * @param string            $name
     * @param array             $options
     *
     * @return GridBuilderInterface
     */
    public function createBuilder(RegistryInterface $registry, $name, array $options = []);

    /**
     * @param GridBuilderInterface $builder
     * @param array                $options
     */
    public function buildGrid(GridBuilderInterface $builder, array $options);

    /**
     * @param GridInterface $grid
     *
     * @return GridView
     */
    public function createGridView(GridInterface $grid);

    /**
     * @param GridView      $view
     * @param GridInterface $grid
     * @param array         $options
     */
    public function buildGridView(GridView $view, GridInterface $grid, array $options);

    /**
     * @param GridView   $grid
     * @param int|string $index
     *
     * @return RowView
     */
    public function createRowView(GridView $grid, $index);

    /**
     * @param RowView       $view
     * @param GridInterface $grid
     * @param array         $options
     */
    public function buildRowView(RowView $view, GridInterface $grid, array $options);

    /**
     * @return OptionsResolver
     */
    public function getOptionsResolver();

    /**
     * @return GridTypeInterface
     */
    public function getInnerType();

    /**
     * @return self|null
     */
    public function getParent();

    /**
     * @return string|null
     */
    public function getBlockPrefix();
}