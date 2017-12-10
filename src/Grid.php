<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataSource\ArrayDataSource;
use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\RequestHandler\NativeRequestHandler;
use PE\Component\Grid\RequestHandler\RequestHandlerInterface;

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
     * @var RequestHandlerInterface
     */
    protected $requestHandler;

    /**
     * @var DataSourceInterface
     */
    protected $dataSource;

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
    public function getDataSource()
    {
        if ($this->dataSource === null) {
            $this->dataSource = new ArrayDataSource([]);
        }

        return $this->dataSource;
    }

    /**
     * @inheritdoc
     */
    public function setDataSource(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @inheritdoc
     */
    public function getRequestHandler()
    {
        if ($this->requestHandler === null) {
            $this->requestHandler = new NativeRequestHandler();
        }

        return $this->requestHandler;
    }

    /**
     * @inheritdoc
     */
    public function setRequestHandler(RequestHandlerInterface $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    /**
     * @inheritDoc
     */
    public function handleRequest($request = null)
    {
        $this->getRequestHandler()->handleRequest($this, $request);
    }

    /**
     * @inheritDoc
     */
    public function createView()
    {
        $type    = $this->getType();
        $options = $this->getOptions();

        $type->buildGridView($view = $type->createGridView($this), $this, $options);

        return $view;
    }
}