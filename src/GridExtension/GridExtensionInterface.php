<?php

namespace PE\Component\Grid\GridExtension;

use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\GridType\GridTypeInterface;
use PE\Component\Grid\GridTypeExtension\GridTypeExtensionInterface;

interface GridExtensionInterface
{
    /**
     * @param string $name
     *
     * @return GridTypeInterface
     *
     * @throws InvalidArgumentException
     */
    public function getType($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasType($name);

    /**
     * @param string $name
     *
     * @return GridTypeExtensionInterface[]
     */
    public function getTypeExtensions($name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasTypeExtensions($name);
}