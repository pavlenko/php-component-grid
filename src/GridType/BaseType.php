<?php

namespace PE\Component\Grid\GridType;

use PE\Component\Grid\AbstractGridType;

/**
 * @codeCoverageIgnore
 */
class BaseType extends AbstractGridType
{
    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'grid';
    }
}