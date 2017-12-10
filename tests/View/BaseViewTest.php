<?php

namespace PETest\Component\Grid\View;

use PE\Component\Grid\View\BaseView;

class BaseViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseView
     */
    private $view;

    protected function setUp()
    {
        $this->view = $this->getMockForAbstractClass(BaseView::class);
    }

    public function testGetVars()
    {
        static::assertSame([], $this->view->getVars());
        $this->view->setVar('foo', 'bar');
        static::assertSame(['foo' => 'bar'], $this->view->getVars());
    }

    public function testSetVar()
    {
        $this->view->setVar('foo', 'bar');
    }

    public function testGetVar()
    {
        static::assertNull($this->view->getVar('foo'));
        static::assertSame('default', $this->view->getVar('foo', 'default'));
        $this->view->setVar('foo', 'bar');
        static::assertSame('bar', $this->view->getVar('foo'));
    }

    public function testHasVar()
    {
        static::assertFalse($this->view->hasVar('foo'));
        $this->view->setVar('foo', 'bar');
        static::assertTrue($this->view->hasVar('foo'));
    }
}
