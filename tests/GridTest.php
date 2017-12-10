<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\DataSource\ArrayDataSource;
use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Grid;
use PE\Component\Grid\RequestHandler\NativeRequestHandler;
use PE\Component\Grid\RequestHandler\RequestHandlerInterface;
use PE\Component\Grid\ResolvedGridTypeInterface;
use PE\Component\Grid\View\GridView;

class GridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResolvedGridTypeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $type;

    /**
     * @var Grid
     */
    protected $grid;

    protected function setUp()
    {
        $this->type = $this->createMock(ResolvedGridTypeInterface::class);
        $this->grid = new Grid('grid', $this->type, ['foo' => 'bar'], []);
    }

    public function testGrid()
    {
        /* @var $dataSource DataSourceInterface|\PHPUnit_Framework_MockObject_MockObject */
        $dataSource = $this->createMock(DataSourceInterface::class);

        /* @var $requestHandler RequestHandlerInterface|\PHPUnit_Framework_MockObject_MockObject */
        $requestHandler = $this->createMock(RequestHandlerInterface::class);

        static::assertEquals('grid', $this->grid->getName());
        static::assertEquals($this->type, $this->grid->getType());
        static::assertEquals(['foo' => 'bar'], $this->grid->getOptions());

        static::assertInstanceOf(ArrayDataSource::class, $this->grid->getDataSource());

        $this->grid->setDataSource($dataSource);

        static::assertEquals($dataSource, $this->grid->getDataSource());

        static::assertInstanceOf(NativeRequestHandler::class, $this->grid->getRequestHandler());

        $this->grid->setRequestHandler($requestHandler);

        static::assertEquals($requestHandler, $this->grid->getRequestHandler());
    }

    public function testHandleRequestCallRequestHandler()
    {
        /* @var $requestHandler RequestHandlerInterface|\PHPUnit_Framework_MockObject_MockObject */
        $requestHandler = $this->createMock(RequestHandlerInterface::class);
        $requestHandler->expects(static::once())->method('handleRequest');

        $this->grid->setRequestHandler($requestHandler);
        $this->grid->handleRequest();
    }

    public function testCreateView()
    {
        $view = $this->createMock(GridView::class);

        $this->type->expects(static::once())->method('createGridView')->willReturn($view);
        $this->type->expects(static::once())->method('buildGridView');

        $view = $this->grid->createView();

        static::assertInstanceOf(GridView::class, $view);
    }
}
