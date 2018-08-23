<?php

namespace PE\Component\Grid\GridExtension;

use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\GridExtension\GridExtensionInterface;
use PE\Component\Grid\GridTypeExtension\GridTypeExtensionInterface;
use Psr\Container\ContainerInterface;

class ContainerExtension implements GridExtensionInterface
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
     * @param ContainerInterface           $typeContainer
     * @param GridTypeExtensionInterface[] $typeExtensions
     */
    public function __construct(ContainerInterface $typeContainer, array $typeExtensions)
    {
        $this->typeContainer = $typeContainer;

        foreach ($typeExtensions as $typeExtension) {
            if (!($typeExtension instanceof GridTypeExtensionInterface)) {
                throw new UnexpectedValueException($typeExtension, GridTypeExtensionInterface::class);
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