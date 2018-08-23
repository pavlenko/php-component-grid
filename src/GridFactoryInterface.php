<?php

namespace PE\Component\Grid;

use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\GridType\BaseGridType;

interface GridFactoryInterface
{
    /**
     * @param string                  $type
     * @param null|array|\Traversable $data
     * @param array                   $options
     *
     * @return GridInterface
     *
     * @throws ExceptionInterface
     */
    public function create($type = BaseGridType::class, $data = null, array $options = []);

    /**
     * @param string                  $name
     * @param string                  $type
     * @param null|array|\Traversable $data
     * @param array                   $options
     *
     * @return GridInterface
     *
     * @throws ExceptionInterface
     */
    public function createNamed($name, $type = BaseGridType::class, $data = null, array $options = []);

    /**
     * @param string                  $type
     * @param null|array|\Traversable $data
     * @param array                   $options
     *
     * @return GridBuilderInterface
     *
     * @throws ExceptionInterface
     */
    public function createBuilder($type = BaseGridType::class, $data = null, array $options = []);

    /**
     * @param string                  $name
     * @param string                  $type
     * @param null|array|\Traversable $data
     * @param array                   $options
     *
     * @return GridBuilderInterface
     *
     * @throws ExceptionInterface
     */
    public function createNamedBuilder($name, $type = BaseGridType::class, $data = null, array $options = []);
}