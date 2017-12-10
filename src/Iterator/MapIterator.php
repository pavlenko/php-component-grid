<?php

namespace PE\Component\Grid\Iterator;

class MapIterator extends \IteratorIterator implements IteratorInterface
{
    /**
     * @var IteratorInterface
     */
    private $iterator;

    /**
     * @var callable
     */
    private $callback;

    /**
     * Constructor
     *
     * @param IteratorInterface $iterator
     * @param callable          $callback
     */
    public function __construct(IteratorInterface $iterator, callable $callback)
    {
        parent::__construct($this->iterator = $iterator);
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return call_user_func($this->callback, parent::current());
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->iterator);
    }
}