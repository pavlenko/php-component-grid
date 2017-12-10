<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\ColumnTypeExtensionInterface;
use PE\Component\Grid\ColumnTypeInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\ResolvedColumnType;
use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\HeaderView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolvedColumnTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ColumnTypeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $parentType;

    /**
     * @var ColumnTypeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $type;

    /**
     * @var ColumnTypeExtensionInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $extension1;

    /**
     * @var ColumnTypeExtensionInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $extension2;

    /**
     * @var ResolvedColumnType
     */
    protected $parentResolvedType;

    /**
     * @var ResolvedColumnType
     */
    protected $resolvedType;

    protected function setUp()
    {
        $this->parentType = $this->createMock(ColumnTypeInterface::class);
        $this->type       = $this->createMock(ColumnTypeInterface::class);

        $this->extension1 = $this->createMock(ColumnTypeExtensionInterface::class);
        $this->extension2 = $this->createMock(ColumnTypeExtensionInterface::class);

        $this->parentResolvedType = new ResolvedColumnType($this->parentType);

        $this->resolvedType = new ResolvedColumnType(
            $this->type,
            [$this->extension1, $this->extension2],
            $this->parentResolvedType
        );
    }

    public function testConstructWithInvalidExtensionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new ResolvedColumnType($this->type, [1]);
    }

    public function testInnerType()
    {
        $resolved = new ResolvedColumnType($this->type, []);
        static::assertEquals($resolved->getInnerType(), $this->type);
    }

    public function testGetOptionsResolver()
    {
        $this->parentType
            ->expects(static::once())
            ->method('configureOptions')
            ->willReturnCallback(function(OptionsResolver $resolver){
                $resolver->setDefaults(['parent_type_foo' => 'bar']);
            });

        $this->type
            ->expects(static::once())
            ->method('configureOptions')
            ->willReturnCallback(function(OptionsResolver $resolver){
                $resolver->setDefaults(['type_foo' => 'bar']);
            });

        $this->extension1
            ->expects(static::once())
            ->method('configureOptions')
            ->willReturnCallback(function(OptionsResolver $resolver){
                $resolver->setDefaults(['extension1_foo' => 'bar']);
            });

        $this->extension2
            ->expects(static::once())
            ->method('configureOptions')
            ->willReturnCallback(function(OptionsResolver $resolver){
                $resolver->setDefaults(['extension2_foo' => 'bar']);
            });

        $defaults = [
            'parent_type_foo' => 'bar',
            'type_foo'        => 'bar',
            'extension1_foo'  => 'bar',
            'extension2_foo'  => 'bar',
        ];

        static::assertEquals($defaults, $this->resolvedType->getOptionsResolver()->resolve([]));
    }

    public function testCreateColumn()
    {
        $name    = 'foo';
        $options = [];

        static::assertInstanceOf(ColumnInterface::class, $this->resolvedType->createColumn($name, $options));
    }

    public function testBuildHeaderView()
    {
        /* @var $view HeaderView|\PHPUnit_Framework_MockObject_MockObject */
        $view = $this->createMock(HeaderView::class);

        /* @var $column ColumnInterface|\PHPUnit_Framework_MockObject_MockObject */
        $column = $this->createMock(ColumnInterface::class);

        $options = [];

        $i = 0;

        $assertIndex = function ($index) use (&$i) {
            return function () use (&$i, $index) {
                static::assertEquals($index, $i++);
            };
        };

        $this->parentType
            ->expects(static::once())
            ->method('buildHeaderView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(0));

        $this->type
            ->expects(static::once())
            ->method('buildHeaderView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(1));

        $this->extension1
            ->expects(static::once())
            ->method('buildHeaderView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(2));

        $this->extension2
            ->expects(static::once())
            ->method('buildHeaderView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(3));

        $this->resolvedType->buildHeaderView($view, $column, $options);
    }

    public function testBuildCellView()
    {
        /* @var $view CellView|\PHPUnit_Framework_MockObject_MockObject */
        $view = $this->createMock(CellView::class);

        /* @var $column ColumnInterface|\PHPUnit_Framework_MockObject_MockObject */
        $column = $this->createMock(ColumnInterface::class);

        $options = [];

        $i = 0;

        $assertIndex = function ($index) use (&$i) {
            return function () use (&$i, $index) {
                static::assertEquals($index, $i++);
            };
        };

        $this->parentType
            ->expects(static::once())
            ->method('buildCellView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(0));

        $this->type
            ->expects(static::once())
            ->method('buildCellView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(1));

        $this->extension1
            ->expects(static::once())
            ->method('buildCellView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(2));

        $this->extension2
            ->expects(static::once())
            ->method('buildCellView')
            ->with($view, $column, $options)
            ->willReturnCallback($assertIndex(3));

        $this->resolvedType->buildCellView($view, $column, $options);
    }
}
