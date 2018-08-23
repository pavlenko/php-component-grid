<?php

namespace PE\Component\Grid\View;

class ColumnView extends BaseView
{
    /**
     * @var string
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