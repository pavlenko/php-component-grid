<?php

namespace PE\Component\Grid;

use PE\Component\Grid\ColumnExtension\ColumnExtensionInterface;
use PE\Component\Grid\ColumnExtension\PreloadedExtension as ColumnPreloadedExtension;
use PE\Component\Grid\ColumnType\ColumnTypeInterface;
use PE\Component\Grid\ColumnTypeExtension\ColumnTypeExtensionInterface;
use PE\Component\Grid\GridExtension\GridExtensionInterface;
use PE\Component\Grid\GridExtension\PreloadedExtension as GridPreloadedExtension;
use PE\Component\Grid\GridType\GridTypeInterface;
use PE\Component\Grid\GridTypeExtension\GridTypeExtensionInterface;

class GridFactoryBuilder implements GridFactoryBuilderInterface
{
    /**
     * @var GridExtensionInterface[]
     */
    private $gridExtensions = [];

    /**
     * @var GridTypeInterface[]
     */
    private $gridTypes = [];

    /**
     * @var GridTypeExtensionInterface[]
     */
    private $gridTypeExtensions = [];

    /**
     * @var ColumnExtensionInterface[]
     */
    private $columnExtensions = [];

    /**
     * @var ColumnTypeInterface[]
     */
    private $columnTypes = [];

    /**
     * @var ColumnTypeExtensionInterface[]
     */
    private $columnTypeExtensions = [];

    /**
     * @inheritDoc
     */
    public function addGridExtension(GridExtensionInterface $extension)
    {
        $this->gridExtensions[] = $extension;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addGridType(GridTypeInterface $type)
    {
        $this->gridTypes[] = $type;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addGridTypeExtension(GridTypeExtensionInterface $extension)
    {
        $this->gridTypeExtensions[] = $extension;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addColumnExtension(ColumnExtensionInterface $extension)
    {
        $this->columnExtensions[] = $extension;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addColumnType(ColumnTypeInterface $type)
    {
        $this->columnTypes[] = $type;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addColumnTypeExtension(ColumnTypeExtensionInterface $extension)
    {
        $this->columnTypeExtensions[] = $extension;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getGridFactory()
    {
        $gridExtensions   = $this->gridExtensions;
        $gridExtensions[] = new GridPreloadedExtension($this->gridTypes, $this->gridTypeExtensions);

        $columnExtensions   = $this->columnExtensions;
        $columnExtensions[] = new ColumnPreloadedExtension($this->columnTypes, $this->columnTypeExtensions);

        return new GridFactory(new Registry($gridExtensions, $columnExtensions));
    }
}