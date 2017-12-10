<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataMapper\DataMapperInterface;

interface ColumnInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return ResolvedColumnTypeInterface
     */
    public function getType();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @return DataMapperInterface
     */
    public function getDataMapper();

    /**
     * @param DataMapperInterface $dataMapper
     */
    public function setDataMapper(DataMapperInterface $dataMapper);
}