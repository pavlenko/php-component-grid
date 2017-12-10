<?php

namespace PE\Component\Grid\View;

class RowView
{
    /**
     * @var CellView[]
     */
    private $cells = [];

    /**
     * @param CellView[] $cells
     */
    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    /**
     * @return CellView[]
     */
    public function getCells()
    {
        return $this->cells;
    }
}