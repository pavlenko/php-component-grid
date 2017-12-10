<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataSource\ArrayDataSource;
use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\GridType\BaseType;

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
    public function create($type = BaseType::class, $data = null, array $options = [])
    {
        return $this->createNamed('grid', $type, $data, $options);
    }

    /**
     * @inheritDoc
     */
    public function createNamed($name, $type = BaseType::class, $data = null, array $options = [])
    {
        return $this->createNamedBuilder($name, $type, $data, $options)->getGrid();
    }

    /**
     * @inheritDoc
     */
    public function createBuilder($type = BaseType::class, $data = null, array $options = [])
    {
        return $this->createNamedBuilder('grid', $type, $data, $options);
    }

    /**
     * @inheritDoc
     */
    public function createNamedBuilder($name, $type = BaseType::class, $data = null, array $options = [])
    {
        if (!is_string($type)) {
            throw new UnexpectedValueException($type, 'string');
        }

        if ($data !== null) {
            if (is_array($data)) {
                $data = new ArrayDataSource($data);
            }

            if (!($data instanceof DataSourceInterface)) {
                throw new UnexpectedValueException($type, 'null or array or instance of' . DataSourceInterface::class);
            }
        }

        $type    = $this->registry->getGridType($type);
        $builder = $type->createBuilder($this->registry, $name, $options);

        if ($data !== null) {
            $builder->setDataSource($data);
        }

        $type->buildGrid($builder, $builder->getOptions());
        return $builder;
    }
}