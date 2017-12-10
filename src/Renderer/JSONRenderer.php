<?php

namespace PE\Component\Grid\Renderer;

use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;

class JSONRenderer implements GridRendererInterface
{
    public function setTheme(GridView $view, array $themes)
    {
        // Themes not used in this renderer
    }

    //TODO complete grid view hierarchy
    public function renderGrid(GridView $view)
    {
        $result = [
            'columns' => $view->getColumns(),
            'rowset'  => $view,
        ];

        /* @var $row RowView */
        foreach ($view as $row) {
            /* @var $cell CellView */
            foreach ($row as $cell) {
                $result['rowset'][$cell] = $cell->getValue();
            }
        }

        return $result;
    }

    public function renderRow(RowView $view)
    {
        // TODO: Implement renderRow() method.
    }

    public function renderHeader(CellView $view)
    {
        // TODO: Implement renderHeader() method.
    }

    public function renderCell(CellView $view)
    {
        // TODO: Implement renderCell() method.
    }
}