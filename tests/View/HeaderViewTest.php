<?php

namespace PETest\Component\Grid\View;

use PE\Component\Grid\View\BaseView;
use PE\Component\Grid\View\HeaderView;

class HeaderViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HeaderView
     */
    private $view;

    protected function setUp()
    {
        $this->view = new HeaderView('name', 'type');
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
}
