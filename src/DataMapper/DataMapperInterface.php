<?php

namespace PE\Component\Grid\DataMapper;

use PE\Component\Grid\Exception\ExceptionInterface;

interface DataMapperInterface
{
    /**
     * @param mixed  $data
     * @param string $field
     *
     * @return mixed
     *
     * @throws ExceptionInterface
     */
    public function getValue($data, $field);

    /**
     * @param mixed  $data
     * @param string $field
     * @param mixed  $value
     *
     * @throws ExceptionInterface
     */
    public function setValue(&$data, $field, $value);
}