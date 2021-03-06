<?php

namespace PE\Component\Grid\View;

class CellView extends BaseView
{
    /**
     * @var GridView
     */
    public $grid;

    /**
     * @var string
     */
    public $name;

    /**
     * @param GridView $grid
     * @param string   $name
     */
    public function __construct(GridView $grid, $name)
    {
        $this->grid = $grid;
        $this->name = $name;
    }
}