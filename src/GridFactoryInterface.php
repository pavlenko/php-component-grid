<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\GridType\BaseType;

interface GridFactoryInterface
{
    /**
     * @param string                         $type
     * @param null|array|DataSourceInterface $data
     * @param array                          $options
     *
     * @return GridInterface
     *
     * @throws ExceptionInterface
     */
    public function create($type = BaseType::class, $data = null, array $options = []);

    /**
     * @param string                         $name
     * @param string                         $type
     * @param null|array|DataSourceInterface $data
     * @param array                          $options
     *
     * @return GridInterface
     *
     * @throws ExceptionInterface
     */
    public function createNamed($name, $type = BaseType::class, $data = null, array $options = []);

    /**
     * @param string                         $type
     * @param null|array|DataSourceInterface $data
     * @param array                          $options
     *
     * @return GridBuilderInterface
     *
     * @throws ExceptionInterface
     */
    public function createBuilder($type = BaseType::class, $data = null, array $options = []);

    /**
     * @param string                         $name
     * @param string                         $type
     * @param null|array|DataSourceInterface $data
     * @param array                          $options
     *
     * @return GridBuilderInterface
     *
     * @throws ExceptionInterface
     */
    public function createNamedBuilder($name, $type = BaseType::class, $data = null, array $options = []);
}