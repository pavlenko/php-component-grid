<?php

namespace PE\Component\Grid;

use PE\Component\Grid\Exception\UnexpectedValueException;

class Grid implements GridInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ResolvedGridTypeInterface
     */
    protected $type;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var ColumnInterface[]
     */
    protected $columns = [];

    /**
     * @var array|\Traversable
     */
    protected $data = [];

    /**
     * @param string                    $name
     * @param ResolvedGridTypeInterface $type
     * @param array                     $options
     * @param ColumnInterface[]         $columns
     */
    public function __construct(
        $name,
        ResolvedGridTypeInterface $type,
        array $options,
        array $columns
    ) {
        $this->name    = $name;
        $this->type    = $type;
        $this->options = $options;
        $this->columns = $columns;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function setData($data)
    {
        if (!is_array($data) && !($data instanceof \Traversable)) {
            throw new UnexpectedValueException($data, 'array or \Traversable');
        }

        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function createView()
    {
        $gridType    = $this->getType();
        $gridOptions = $this->getOptions();
        $gridView    = $gridType->createGridView($this);

        $gridType->buildGridView($gridView, $this, $gridOptions);

        foreach ($this->columns as $name => $column) {
            $columnType    = $column->getType();
            $columnOptions = $column->getOptions();
            $columnView    = $columnType->createColumnView($gridView, $name);

            $columnType->buildColumnView($columnView, $column, $columnOptions);

            $gridView->columns[$name] = $columnView;
        }

        foreach ($this->data as $index => $row) {
            $rowView = $gridType->createRowView($gridView, $index);

            $gridType->buildRowView($rowView, $this, $gridOptions);//TODO pass row to build?

            foreach ($gridView->columns as $name => $columnView) {
                $column        = $this->columns[$name];
                $columnType    = $column->getType();
                $columnOptions = $column->getOptions();
                $cellView      = $columnType->createCellView($gridView, $name);

                if ($columnOptions['mapped']) {//TODO map value
                    //$cellView->setValue($column->getDataMapper()->getValue($row, $column->getName()));
                    $cellView->vars['value'] = $column->getDataMapper()->getValue($row, $column->getName());
                }

                $columnType->buildCellView($cellView, $column, $row, $columnOptions);

                $rowView->cells[$name] = $cellView;
            }

            $gridView->rows[] = $rowView;
        }

        return $gridView;
    }
}