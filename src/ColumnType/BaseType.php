<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\AbstractColumnType;

/**
 * @codeCoverageIgnore
 */
class BaseType extends AbstractColumnType
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
        return 'column';
    }
}