<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\RequestHandler\RequestHandlerInterface;
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
     * @return DataSourceInterface
     */
    public function getDataSource();

    /**
     * @param DataSourceInterface $dataSource
     */
    public function setDataSource(DataSourceInterface $dataSource);

    /**
     * @return RequestHandlerInterface
     */
    public function getRequestHandler();

    /**
     * @param RequestHandlerInterface $requestHandler
     */
    public function setRequestHandler(RequestHandlerInterface $requestHandler);

    /**
     * @param mixed $request
     *
     * @throws ExceptionInterface
     */
    public function handleRequest($request = null);

    /**
     * @return GridView
     */
    public function createView();
}