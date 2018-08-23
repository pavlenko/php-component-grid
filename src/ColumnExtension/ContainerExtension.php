<?php

namespace PE\Component\Grid\ColumnExtension;

use PE\Component\Grid\ColumnExtension\ColumnExtensionInterface;
use PE\Component\Grid\ColumnTypeExtension\ColumnTypeExtensionInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\UnexpectedValueException;
use Psr\Container\ContainerInterface;

class ContainerExtension implements ColumnExtensionInterface
{
    /**
     * @var ContainerInterface
     */
    private $typeContainer;

    /**
     * @var array
     */
    private $typeExtensions = [];

    /**
     * @param ContainerInterface             $typeContainer
     * @param ColumnTypeExtensionInterface[] $typeExtensions
     */
    public function __construct(ContainerInterface $typeContainer, array $typeExtensions)
    {
        $this->typeContainer = $typeContainer;

        foreach ($typeExtensions as $typeExtension) {
            if (!($typeExtension instanceof ColumnTypeExtensionInterface)) {
                throw new UnexpectedValueException($typeExtension, ColumnTypeExtensionInterface::class);
            }

            $this->typeExtensions[$typeExtension->getExtendedType()][] = $typeExtension;
        }
    }

    /**
     * @inheritDoc
     */
    public function getType($name)
    {
        if (!$this->typeContainer->has($name)) {
            throw new InvalidArgumentException(sprintf(
                'The type "%s" is not registered in the service container.',
                $name
            ));
        }

        return $this->typeContainer->get($name);
    }

    /**
     * @inheritDoc
     */
    public function hasType($name)
    {
        return $this->typeContainer->has($name);
    }

    /**
     * @inheritDoc
     */
    public function getTypeExtensions($name)
    {
        return isset($this->typeExtensions[$name])
            ? $this->typeExtensions[$name]
            : array();
    }

    /**
     * @inheritDoc
     */
    public function hasTypeExtensions($name)
    {
        return isset($this->typeExtensions[$name]) && count($this->typeExtensions[$name]) > 0;
    }
}