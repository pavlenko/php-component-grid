<?php

namespace PE\Component\Grid\Renderer;

use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;

interface GridRendererInterface
{
    /**
     * Sets the theme(s) to be used for rendering a view and its children.
     *
     * @param GridView $view   The view to assign the theme(s) to
     * @param string[] $themes The themes names.
     */
    public function setTheme(GridView $view, array $themes);

    /**
     * @param GridView $view
     *
     * @return string
     */
    public function renderGrid(GridView $view);

    public function renderRow(RowView $view);

    public function renderHeader(CellView $view);

    public function renderCell(CellView $view);
}