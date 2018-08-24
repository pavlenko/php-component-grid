<?php

namespace PE\Component\Grid;

final class Grids
{
    /**
     * Prevent instantiate class
     */
    private function __construct()
    {}

    /**
     * @return GridFactoryInterface
     */
    public static function createGridFactory()
    {
        return self::createGridFactoryBuilder()->getGridFactory();
    }

    /**
     * @return GridFactoryBuilder
     */
    public static function createGridFactoryBuilder()
    {
        return new GridFactoryBuilder();
    }
}