<?php

namespace PE\Component\Grid;

use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\DataMapper\DataMapperInterface;
use PE\Component\Grid\Exception\ExceptionInterface;

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
     * @return array|\Traversable
     */
    public function getData();

    /**
     * @param array|\Traversable $data
     */
    public function setData($data);

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