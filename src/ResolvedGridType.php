<?php

namespace PE\Component\Grid;

use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\GridType\GridTypeInterface;
use PE\Component\Grid\GridTypeExtension\GridTypeExtensionInterface;
use PE\Component\Grid\View\GridView;
use PE\Component\Grid\View\RowView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolvedGridType implements ResolvedGridTypeInterface
{
    /**
     * @var GridTypeInterface
     */
    protected $innerType;

    /**
     * @var GridTypeExtensionInterface[]
     */
    protected $typeExtensions = [];

    /**
     * @var ResolvedGridTypeInterface|null
     */
    protected $parent;

    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * Constructor
     *
     * @param GridTypeInterface              $type
     * @param GridTypeExtensionInterface[]   $typeExtensions
     * @param ResolvedGridTypeInterface|null $parent
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        GridTypeInterface $type,
        array $typeExtensions = [],
        ResolvedGridTypeInterface $parent = null
    ) {
        foreach ($typeExtensions as $typeExtension) {
            if (!($typeExtension instanceof GridTypeExtensionInterface)) {
                throw new InvalidArgumentException(
                    'Grid type extension must be instance of ' . GridTypeExtensionInterface::class
                );
            }
        }

        $this->innerType      = $type;
        $this->typeExtensions = $typeExtensions;
        $this->parent         = $parent;
    }

    /**
     * @inheritDoc
     */
    public function getInnerType()
    {
        return $this->innerType;
    }

    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return $this->innerType->getBlockPrefix();
    }

    /**
     * @inheritDoc
     */
    public function createBuilder(RegistryInterface $registry, $name, array $options = [])
    {
        return new GridBuilder($registry, $name, $this, $this->getOptionsResolver()->resolve($options));
    }

    /**
     * @inheritDoc
     */
    public function buildGrid(GridBuilderInterface $builder, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildGrid($builder, $options);
        }

        $this->innerType->buildGrid($builder, $options);

        foreach ($this->typeExtensions as $extension) {
            $extension->buildGrid($builder, $options);
        }
    }

    /**
     * @inheritdoc
     */
    public function createGridView(GridInterface $grid)
    {
        return new GridView($grid->getName());
    }

    /**
     * @inheritDoc
     */
    public function buildGridView(GridView $view, GridInterface $grid, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildGridView($view, $grid, $options);
        }

        $this->innerType->buildGridView($view, $grid, $options);

        foreach ($this->typeExtensions as $extension) {
            $extension->buildGridView($view, $grid, $options);
        }
    }

    /**
     * @inheritDoc
     */
    public function createRowView(GridView $grid, $index)
    {
        return new RowView($grid, $index);
    }

    /**
     * @inheritDoc
     */
    public function buildRowView(RowView $view, GridInterface $grid, array $options)
    {
        if (null !== $this->parent) {
            $this->parent->buildRowView($view, $grid, $options);
        }

        $this->innerType->buildRowView($view, $grid, $options);

        foreach ($this->typeExtensions as $extension) {
            $extension->buildRowView($view, $grid, $options);
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