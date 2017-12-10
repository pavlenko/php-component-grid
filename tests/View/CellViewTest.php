<?php

namespace PETest\Component\Grid\View;

use PE\Component\Grid\View\BaseView;
use PE\Component\Grid\View\CellView;

class CellViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CellView
     */
    private $view;

    protected function setUp()
    {
        $this->view = new CellView('name', 'type');
    }

    public function testInstanceOf()
    {
        static::assertInstanceOf(BaseView::class, $this->view);
    }

    public function testGetName()
    {
        static::assertSame('name', $this->view->getName());
    }

    public function testGetType()
    {
        static::assertSame('type', $this->view->getType());
    }

    public function testGetSetValue()
    {
        static::assertNull($this->view->getValue());
        $this->view->setValue('foo');
        static::assertSame('foo', $this->view->getValue());
    }
}
