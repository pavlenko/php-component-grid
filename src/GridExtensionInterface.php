<?php

namespace PE\Component\Grid;

use PE\Component\Grid\Exception\InvalidArgumentException;

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