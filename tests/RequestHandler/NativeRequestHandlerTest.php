<?php

namespace PETest\Component\Grid\RequestHandler;

use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\Grid;
use PE\Component\Grid\GridInterface;
use PE\Component\Grid\RequestHandler\NativeRequestHandler;

class NativeRequestHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NativeRequestHandler
     */
    protected $handler;

    /**
     * @var DataSourceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataSource;

    /**
     * @var GridInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $grid;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->handler    = new NativeRequestHandler();
        $this->dataSource = $this->createMock(DataSourceInterface::class);

        $this->grid = $this->createMock(Grid::class);
        $this->grid->method('getDataSource')->willReturn($this->dataSource);
    }

    public function testHandleWithNotNullRequestArgumentThrowsException()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->handler->handleRequest($this->grid, 'foo');
    }

    public function handleRequestProvider()
    {
        return [
            [
                '',
                [
                    'criteria' => ['foo' => 'bar'],
                    'order_by' => ['baz' => 'foo'],
                    'limit'    => 10,
                    'offset'   => 2,
                ]
            ],
            [
                'grid',
                [
                    'grid' => [
                        'criteria' => ['foo' => 'bar'],
                        'order_by' => ['baz' => 'foo'],
                        'limit'    => 10,
                        'offset'   => 2,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider handleRequestProvider
     *
     * @param $name
     * @param $request
     */
    public function testHandleRequest($name, $request)
    {
        $this->grid->method('getName')->willReturn($name);

        $oldRequest = $_REQUEST;
        $_REQUEST   = $request;

        $this->dataSource->expects(static::once())->method('setCriteria');
        $this->dataSource->expects(static::once())->method('setOrderBy');
        $this->dataSource->expects(static::once())->method('setLimit');
        $this->dataSource->expects(static::once())->method('setOffset');

        $this->handler->handleRequest($this->grid);

        $_REQUEST = $oldRequest;
    }

    public function handleRequestWithPageProvider()
    {
        return [
            [
                '',
                [
                    'limit' => 10,
                    'page'  => 2,
                ]
            ],
            [
                'grid',
                [
                    'grid' => [
                        'limit' => 10,
                        'page'  => 2,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider handleRequestWithPageProvider
     *
     * @param $name
     * @param $request
     */
    public function testHandleRequestWithPage($name, $request)
    {
        $this->grid->method('getName')->willReturn($name);

        $oldRequest = $_REQUEST;
        $_REQUEST   = $request;

        $this->dataSource->expects(static::once())->method('setLimit');
        $this->dataSource->expects(static::once())->method('setOffset');

        $this->handler->handleRequest($this->grid);

        $_REQUEST = $oldRequest;
    }

    public function testNotHandleRequestForNamedGridIfRequestHasNotParams()
    {
        $this->grid->method('getName')->willReturn('grid');

        $this->dataSource->expects(static::never())->method('setLimit');

        $this->handler->handleRequest($this->grid);
    }
}
