<?php

namespace PE\Component\Grid\View;

use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\Iterator\IteratorInterface;

class GridView extends BaseView
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var HeaderView[]
     */
    private $headers = [];

    /**
     * @var array|IteratorInterface
     */
    private $rows = [];

    /**
     * Constructor
     *
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return HeaderView[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param HeaderView[] $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array|IteratorInterface
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param array|IteratorInterface $rows
     *
     * @throws UnexpectedValueException
     */
    public function setRows($rows)
    {
        if (!is_array($rows) && !($rows instanceof IteratorInterface)) {
            throw new UnexpectedValueException($rows, 'array or ' . IteratorInterface::class);
        }

        $this->rows = $rows;
    }
}