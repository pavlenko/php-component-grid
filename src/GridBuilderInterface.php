<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataMapper\DataMapperInterface;
use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\RequestHandler\RequestHandlerInterface;

interface GridBuilderInterface
{
    /**
     * @param string                          $child
     * @param null|string|ColumnTypeInterface $type
     * @param array                           $options
     *
     * @throws ExceptionInterface
     */
    public function add($child, $type = null, array $options = []);

    /**
     * @param string $child
     *
     * @return ColumnTypeInterface
     *
     * @throws ExceptionInterface
     */
    public function get($child);

    /**
     * @param string $child
     *
     * @return boolean
     *
     * @throws ExceptionInterface
     */
    public function has($child);

    /**
     * @param string $child
     *
     * @throws ExceptionInterface
     */
    public function remove($child);

    /**
     * @return ColumnTypeInterface[]
     *
     * @throws ExceptionInterface
     */
    public function all();

    /**
     * @return RequestHandlerInterface
     */
    public function getRequestHandler();

    /**
     * @param RequestHandlerInterface $requestHandler
     */
    public function setRequestHandler(RequestHandlerInterface $requestHandler);

    /**
     * @return DataSourceInterface
     */
    public function getDataSource();

    /**
     * @param DataSourceInterface $dataSource
     */
    public function setDataSource(DataSourceInterface $dataSource);

    /**
     * @return DataMapperInterface
     */
    public function getDataMapper();

    /**
     * @param DataMapperInterface $dataMapper
     */
    public function setDataMapper(DataMapperInterface $dataMapper);

    /**
     * @return GridInterface
     *
     * @throws ExceptionInterface
     */
    public function getGrid();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getOptions();
}