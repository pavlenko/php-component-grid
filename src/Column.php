<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataMapper\DataMapperInterface;
use PE\Component\Grid\DataMapper\ReflectionDataMapper;

class Column implements ColumnInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ResolvedColumnTypeInterface
     */
    protected $type;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var DataMapperInterface
     */
    protected $dataMapper;

    /**
     * @param string                      $name
     * @param ResolvedColumnTypeInterface $type
     * @param array                       $options
     */
    public function __construct($name, ResolvedColumnTypeInterface $type, array $options)
    {
        $this->name    = $name;
        $this->type    = $type;
        $this->options = $options;
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
    public function getDataMapper()
    {
        if ($this->dataMapper === null) {
            $this->dataMapper = new ReflectionDataMapper();
        }

        return $this->dataMapper;
    }

    /**
     * @inheritdoc
     */
    public function setDataMapper(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }
}