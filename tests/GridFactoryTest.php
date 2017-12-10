<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\DataSource\DataSourceInterface;
use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\GridBuilderInterface;
use PE\Component\Grid\GridFactory;
use PE\Component\Grid\GridInterface;
use PE\Component\Grid\GridType\BaseType;
use PE\Component\Grid\Registry;

class GridFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GridFactory
     */
    protected $factory;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->factory = new GridFactory(new Registry([], []));
    }

    public function testCreate()
    {
        $grid = $this->factory->create();
        static::assertInstanceOf(GridInterface::class, $grid);
    }

    public function testCreateNamed()
    {
        $grid = $this->factory->createNamed('test');
        static::assertInstanceOf(GridInterface::class, $grid);
    }

    public function testCreateBuilder()
    {
        $builder = $this->factory->createBuilder();
        static::assertInstanceOf(GridBuilderInterface::class, $builder);
    }

    public function testCreateNamedBuilder()
    {
        $builder = $this->factory->createNamedBuilder('test');
        static::assertInstanceOf(GridBuilderInterface::class, $builder);
    }

    public function testCreateWithData()
    {
        $builder = $this->factory->createBuilder(BaseType::class, []);
        static::assertInstanceOf(DataSourceInterface::class, $builder->getDataSource());
    }

    public function testCreateThrowsExceptionIfInvalidType()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->factory->createBuilder(123);
    }

    public function testCreateThrowsExceptionIfInvalidData()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->factory->createBuilder(BaseType::class, 'string');
    }
}
