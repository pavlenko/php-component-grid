<?php

namespace PETest\Component\Grid\View;

use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\Iterator\IteratorInterface;
use PE\Component\Grid\View\BaseView;
use PE\Component\Grid\View\GridView;

class GridViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GridView
     */
    private $view;

    protected function setUp()
    {
        $this->view = new GridView('name', 'type');
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

    public function testGetSetHeaders()
    {
        static::assertSame([], $this->view->getHeaders());
    }

    public function testSetRowsThrowsExceptionIfInvalidArgument()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->view->setRows(false);
    }

    public function testGetSetRows()
    {
        static::assertSame([], $this->view->getRows());

        /* @var $iterator IteratorInterface|\PHPUnit_Framework_MockObject_MockObject */
        $iterator = $this->createMock(IteratorInterface::class);

        $this->view->setRows($iterator);

        static::assertInstanceOf(IteratorInterface::class, $this->view->getRows());
    }
}
