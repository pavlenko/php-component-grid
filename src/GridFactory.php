<?php

namespace PE\Component\Grid;

use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\GridType\BaseGridType;

class GridFactory implements GridFactoryInterface
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function create($type = BaseGridType::class, $data = null, array $options = [])
    {
        return $this->createNamed('grid', $type, $data, $options);
    }

    /**
     * @inheritDoc
     */
    public function createNamed($name, $type = BaseGridType::class, $data = null, array $options = [])
    {
        return $this->createNamedBuilder($name, $type, $data, $options)->getGrid();
    }

    /**
     * @inheritDoc
     */
    public function createBuilder($type = BaseGridType::class, $data = null, array $options = [])
    {
        return $this->createNamedBuilder('grid', $type, $data, $options);
    }

    /**
     * @inheritDoc
     */
    public function createNamedBuilder($name, $type = BaseGridType::class, $data = null, array $options = [])
    {
        if (!is_string($type)) {
            throw new UnexpectedValueException($type, 'string');
        }

        $type    = $this->registry->getGridType($type);
        $builder = $type->createBuilder($this->registry, $name, $options);

        if ($data !== null) {
            $builder->setData($data);
        }

        $type->buildGrid($builder, $builder->getOptions());
        return $builder;
    }
}