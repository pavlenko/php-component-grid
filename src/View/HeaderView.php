<?php

namespace PE\Component\Grid\View;

class HeaderView extends BaseView
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
     * HeaderView constructor.
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
}