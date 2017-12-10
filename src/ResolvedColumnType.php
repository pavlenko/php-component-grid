<?php

namespace PE\Component\Grid;

use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\HeaderView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolvedColumnType implements ResolvedColumnTypeInterface
{
    /**
     * @var ColumnTypeInterface
     */
    protected $innerType;

    /**
     * @var ColumnTypeExtensionInterface[]
     */
    protected $typeExtensions = [];

    /**
     * @var ResolvedColumnTypeInterface|null
     */
    protected $parent;

    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * Constructor
     *
     * @param ColumnTypeInterface              $type
     * @param ColumnTypeExtensionInterface[]   $typeExtensions
     * @param ResolvedColumnTypeInterface|null $parent
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        ColumnTypeInterface $type,
        array $typeExtensions = [],
        ResolvedColumnTypeInterface $parent = null
    ) {
        foreach ($typeExtensions as $typeExtension) {
            if (!($typeExtension instanceof ColumnTypeExtensionInterface)) {
                throw new InvalidArgumentException(
                    'Column type extension must be instance of ' . ColumnTypeExtensionInterface::class
                );
            }
        }

        $this->innerType      = $type;
        $this->typeExtensions = $typeExtensions;
        $this->parent         = $parent;
    }

    /**
     * @inheritdoc
     */
    public function createColumn($name, array $options)
    {
        return new Column($name, $this, $this->getOptionsResolver()->resolve($options));
    }

    /**
     * @inheritDoc
     */
    public function getInnerType()
    {
        return $this->innerType;
    }

    /**
     * @inheritdoc
     */
    public function createHeaderView(ColumnInterface $column)
    {
        return new HeaderView($column->getName(), $this->getInnerType()->getName());
    }

    /**
     * @inheritDoc
     */
    public function buildHeaderView(HeaderView $view, ColumnInterface $column, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildHeaderView($view, $column, $options);
        }

        $this->innerType->buildHeaderView($view, $column, $options);

        foreach ($this->typeExtensions as $extension) {
            $extension->buildHeaderView($view, $column, $options);
        }
    }

    /**
     * @inheritdoc
     */
    public function createCellView(ColumnInterface $column)
    {
        return new CellView($column->getName(), $this->getInnerType()->getName());
    }

    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildCellView($view, $column, $options);
        }

        $this->innerType->buildCellView($view, $column, $options);

        foreach ($this->typeExtensions as $extension) {
            $extension->buildCellView($view, $column, $options);
        }
    }

    /**
     * @inheritDoc
     */
    public function getOptionsResolver()
    {
        if (null === $this->optionsResolver) {
            if (null !== $this->parent) {
                $this->optionsResolver = clone $this->parent->getOptionsResolver();
            } else {
                $this->optionsResolver = new OptionsResolver();
            }

            $this->innerType->configureOptions($this->optionsResolver);

            foreach ($this->typeExtensions as $extension) {
                $extension->configureOptions($this->optionsResolver);
            }
        }

        return $this->optionsResolver;
    }
}