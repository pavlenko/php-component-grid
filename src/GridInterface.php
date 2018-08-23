<?php

namespace PE\Component\Grid;

use PE\Component\Grid\View\GridView;

interface GridInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return ResolvedGridTypeInterface
     */
    public function getType();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @return ColumnInterface[]
     */
    public function getColumns();

    /**
     * @return array|\Traversable
     */
    public function getData();

    /**
     * @param array|\Traversable $data
     */
    public function setData($data);

    /**
     * @return GridView
     */
    public function createView();
}