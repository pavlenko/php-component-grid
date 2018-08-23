<?php

namespace PE\Component\Grid\View;

class RowView extends BaseView
{
    /**
     * @var GridView
     */
    public $grid;

    /**
     * @var int|string
     */
    public $index;

    /**
     * @var CellView[]
     */
    public $cells = [];

    /**
     * @param GridView   $grid
     * @param int|string $index
     */
    public function __construct(GridView $grid, $index)
    {
        $this->grid  = $grid;
        $this->index = $index;
    }
}