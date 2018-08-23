<?php

namespace PE\Component\Grid\View;

class GridView extends BaseView
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var ColumnView[]
     */
    public $columns = [];

    /**
     * @var array|\Traversable
     */
    public $rows = [];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
}