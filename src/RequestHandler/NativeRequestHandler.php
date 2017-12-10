<?php

namespace PE\Component\Grid\RequestHandler;

use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\GridInterface;

class NativeRequestHandler implements RequestHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handleRequest(GridInterface $grid, $request = null)
    {
        if (null !== $request) {
            throw new UnexpectedValueException($request, 'null');
        }

        $name = $grid->getName();

        if ('' === $name) {
            $request = $_REQUEST;
        } else {
            if (!array_key_exists($name, $_REQUEST)) {
                return;
            }

            $request = $_REQUEST[$name];
        }

        $dataSource = $grid->getDataSource();

        $criteria = (array) @$request['criteria'];
        $orderBy  = (array) @$request['order_by'];
        $limit    = (int) @$request['limit'];
        $offset   = (int) @$request['offset'];
        $page     = (int) @$request['page'];

        // Handle criteria option if exists and not empty
        if (count($criteria)) {
            $dataSource->setCriteria($criteria);
        }

        // Handle orderBy option if exists and not empty
        if (count($orderBy)) {
            $dataSource->setOrderBy($orderBy);
        }

        // Handle limit option if exists and not empty
        if ($limit > 0) {
            $dataSource->setLimit($limit);
        }

        // Handle offset option if exists and not empty
        if ($offset > 0) {
            $dataSource->setOffset($offset);
        }

        // Handle page as offset option if exists and not empty
        if ($limit > 0 && $page > 0) {
            $dataSource->setOffset($page * $limit - $limit);
        }
    }
}