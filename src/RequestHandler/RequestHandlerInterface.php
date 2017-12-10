<?php

namespace PE\Component\Grid\RequestHandler;

use PE\Component\Grid\Exception\ExceptionInterface;
use PE\Component\Grid\GridInterface;

interface RequestHandlerInterface
{
    /**
     * @param GridInterface $grid
     * @param mixed         $request
     *
     * @throws ExceptionInterface
     */
    public function handleRequest(GridInterface $grid, $request = null);
}