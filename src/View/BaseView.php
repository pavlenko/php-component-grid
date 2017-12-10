<?php

namespace PE\Component\Grid\View;

abstract class BaseView
{
    /**
     * @var array
     */
    private $vars = [];

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getVar($name, $default = null)
    {
        return array_key_exists($name, $this->vars) ? $this->vars[$name] : $default;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasVar($name)
    {
        return array_key_exists($name, $this->vars);
    }
}