<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\ColumnType\BaseType;
use PE\Component\Grid\DataMapper\DataMapperInterface;
use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\GridBuilder;
use PE\Component\Grid\Registry;
use PE\Component\Grid\RequestHandler\RequestHandlerInterface;
use PE\Component\Grid\ResolvedGridTypeInterface;

class GridBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GridBuilder
     */
    protected $builder;

    protected function setUp()
    {
        $this->builder = new GridBuilder(
            new Registry([], []),
            'grid',
            $this->createMock(ResolvedGridTypeInterface::class),
            ['foo' => 'bar']
        );
    }

    public function testBuilder()
    {
        static::assertEquals('grid', $this->builder->getName());
        static::assertEquals(['foo' => 'bar'], $this->builder->getOptions());

        static::assertNull($this->builder->getRequestHandler());
        $this->builder->setRequestHandler($requestHandler = $this->createMock(RequestHandlerInterface::class));
        static::assertEquals($requestHandler, $this->builder->getRequestHandler());

        static::assertNull($this->builder->getDataSource());
        $this->builder->setDataSource($dataSource = $this->createMock(DataSourceInterface::class));
        static::assertEquals($dataSource, $this->builder->getDataSource());

        static::assertNull($this->builder->getDataMapper());
        $this->builder->setDataMapper($dataMapper = $this->createMock(DataMapperInterface::class));
        static::assertEquals($dataMapper, $this->builder->getDataMapper());
    }

    public function testGetGridWithRequestHandlerAndDataSource()
    {
        $this->builder->setRequestHandler($requestHandler = $this->createMock(RequestHandlerInterface::class));
        $this->builder->setDataSource($dataSource = $this->createMock(DataSourceInterface::class));

        $grid = $this->builder->getGrid();

        static::assertEquals($requestHandler, $grid->getRequestHandler());
        static::assertEquals($dataSource, $grid->getDataSource());
    }

    public function testAddThrowsExceptionIfTypeIsNotValid()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->builder->add('foo', false);
    }

    public function testAdd()
    {
        static::assertInstanceOf(
            GridBuilder::class,
            $this->builder->add('foo', BaseType::class)
        );

        static::assertInstanceOf(
            GridBuilder::class,
            $this->builder->add($this->createMock(ColumnInterface::class))
        );
    }

    public function testGetThrowsExceptionIfNameInvalid()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->builder->get(false);
    }

    public function testGetThrowsExceptionIfChildNotFound()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->builder->get('foo');
    }

    public function testGet()
    {
        $resolved = $this->createMock(ColumnInterface::class);
        $resolved->method('getName')->willReturn('foo');

        $this->builder->add($resolved);
        static::assertEquals($resolved, $this->builder->get('foo'));

        $this->builder->add('bar', BaseType::class);
        static::assertInstanceOf(ColumnInterface::class, $this->builder->get('bar'));
    }

    public function testHasThrowsExceptionIfNameInvalid()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->builder->has(false);
    }

    public function testHas()
    {
        static::assertFalse($this->builder->has('foo'));

        $this->builder->add('foo', BaseType::class);

        static::assertTrue($this->builder->has('foo'));
    }

    public function testRemoveThrowsExceptionIfNameInvalid()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->builder->remove(false);
    }

    public function testRemove()
    {
        $this->builder->add('foo', BaseType::class);

        static::assertTrue($this->builder->has('foo'));

        $this->builder->remove('foo');

        static::assertFalse($this->builder->has('foo'));
    }

    public function testAll()
    {
        static::assertCount(0, $this->builder->all());

        $this->builder->add('foo', BaseType::class);

        static::assertCount(1, $all = $this->builder->all());

        static::assertInstanceOf(ColumnInterface::class, $all['foo']);
    }

    public function testColumnHasDataMapperIfBuilderHas()
    {
        $this->builder->setDataMapper($dataMapper = $this->createMock(DataMapperInterface::class));
        $this->builder->add('foo', BaseType::class);

        static::assertEquals($dataMapper, $this->builder->get('foo')->getDataMapper());
    }
}
