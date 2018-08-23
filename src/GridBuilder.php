<?php

namespace PE\Component\Grid;

use PE\Component\Grid\DataMapper\DataMapperInterface;
use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\UnexpectedValueException;

class GridBuilder implements GridBuilderInterface
{
    /**
     * @var RegistryInterface
     */
    protected $registry;

    /**
     * @var ResolvedGridTypeInterface
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $unresolvedColumns = [];

    /**
     * @var ColumnInterface[]
     */
    protected $columns = [];

    /**
     * @var DataMapperInterface
     */
    protected $dataMapper;

    /**
     * @var array|\Traversable
     */
    protected $data;

    /**
     * @param RegistryInterface         $registry
     * @param string                    $name
     * @param ResolvedGridTypeInterface $type
     * @param array                     $options
     */
    public function __construct(RegistryInterface $registry, $name, ResolvedGridTypeInterface $type, array $options = [])
    {
        $this->registry = $registry;
        $this->name     = $name;
        $this->type     = $type;
        $this->options  = $options;
    }

    /**
     * @inheritDoc
     */
    public function add($child, $type = null, array $options = [])
    {
        if ($child instanceof ColumnInterface) {
            $this->columns[$child->getName()] = $child;
            return $this;
        }

        if (!is_string($type) && !($type instanceof ColumnInterface)) {
            throw new UnexpectedValueException($child, 'string or ' . ColumnInterface::class);
        }

        $this->columns[$child] = null;
        $this->unresolvedColumns[$child] = [
            'type'    => $type,
            'options' => $options,
        ];

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get($child)
    {
        if (!is_string($child)) {
            throw new UnexpectedValueException($child, 'string');
        }

        if (!array_key_exists($child, $this->columns) && !array_key_exists($child, $this->unresolvedColumns)) {
            throw new InvalidArgumentException(sprintf('Column "%s" not found', $child));
        }

        if ($this->columns[$child] instanceof ColumnInterface) {
            return $this->columns[$child];
        }

        $this->resolve($child);

        return $this->columns[$child];
    }

    /**
     * @inheritDoc
     */
    public function has($child)
    {
        if (!is_string($child)) {
            throw new UnexpectedValueException($child, 'string');
        }

        return array_key_exists($child, $this->unresolvedColumns) || array_key_exists($child, $this->columns);
    }

    /**
     * @inheritDoc
     */
    public function remove($child)
    {
        if (!is_string($child)) {
            throw new UnexpectedValueException($child, 'string');
        }

        unset($this->unresolvedColumns[$child], $this->columns[$child]);
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        foreach ($this->columns as $child => $column) {
            $this->get($child);
        }

        return $this->columns;
    }

    /**
     * @inheritDoc
     */
    public function getGrid()
    {
        $grid = new Grid($this->name, $this->type, $this->options, $this->all());

        if (null !== $this->data) {
            $grid->setData($this->data);
        }

        return $grid;
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
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getDataMapper()
    {
        return $this->dataMapper;
    }

    /**
     * @inheritdoc
     */
    public function setDataMapper(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param string $child
     *
     * @throws ExceptionInterface
     */
    protected function resolve($child)
    {
        $info = $this->unresolvedColumns[$child];
        $type = $this->registry->getColumnType($info['type']);

        $this->columns[$child] = $type->createColumn($child, $info['options']);

        if (null !== $this->dataMapper) {
            $this->columns[$child]->setDataMapper($this->dataMapper);
        }

        unset($this->unresolvedColumns[$child]);
    }
}