<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\GridBuilderInterface;
use PE\Component\Grid\GridInterface;
use PE\Component\Grid\GridTypeExtensionInterface;
use PE\Component\Grid\GridTypeInterface;
use PE\Component\Grid\ResolvedGridType;
use PE\Component\Grid\View\GridView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolvedGridTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GridTypeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $parentType;

    /**
     * @var GridTypeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $type;

    /**
     * @var GridTypeExtensionInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $extension1;

    /**
     * @var GridTypeExtensionInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $extension2;

    /**
     * @var ResolvedGridType
     */
    protected $parentResolvedType;

    /**
     * @var ResolvedGridType
     */
    protected $resolvedType;

    protected function setUp()
    {
        $this->parentType = $this->createMock(GridTypeInterface::class);
        $this->type       = $this->createMock(GridTypeInterface::class);

        $this->extension1 = $this->createMock(GridTypeExtensionInterface::class);
        $this->extension2 = $this->createMock(GridTypeExtensionInterface::class);

        $this->parentResolvedType = new ResolvedGridType($this->parentType);

        $this->resolvedType = new ResolvedGridType(
            $this->type,
            [$this->extension1, $this->extension2],
            $this->parentResolvedType
        );
    }

    public function testConstructWithInvalidExtensionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new ResolvedGridType($this->type, [1]);
    }

    public function testInnerType()
    {
        $resolved = new ResolvedGridType($this->type, []);
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

    public function testBuildGrid()
    {
        /* @var $builder GridBuilderInterface|\PHPUnit_Framework_MockObject_MockObject */
        $builder = $this->createMock(GridBuilderInterface::class);
        $options = [];

        $i = 0;

        $assertIndex = function ($index) use (&$i) {
            return function () use (&$i, $index) {
                static::assertEquals($index, $i++);
            };
        };

        $this->parentType
            ->expects(static::once())
            ->method('buildGrid')
            ->with($builder, $options)
            ->willReturnCallback($assertIndex(0));

        $this->type
            ->expects(static::once())
            ->method('buildGrid')
            ->with($builder, $options)
            ->willReturnCallback($assertIndex(1));

        $this->extension1
            ->expects(static::once())
            ->method('buildGrid')
            ->with($builder, $options)
            ->willReturnCallback($assertIndex(2));

        $this->extension2
            ->expects(static::once())
            ->method('buildGrid')
            ->with($builder, $options)
            ->willReturnCallback($assertIndex(3));

        $this->resolvedType->buildGrid($builder, $options);
    }

    public function testBuildGridView()
    {
        /* @var $view GridView|\PHPUnit_Framework_MockObject_MockObject */
        $view = $this->createMock(GridView::class);

        /* @var $grid GridInterface|\PHPUnit_Framework_MockObject_MockObject */
        $grid = $this->createMock(GridInterface::class);

        $options = [];

        $i = 0;

        $assertIndex = function ($index) use (&$i) {
            return function () use (&$i, $index) {
                static::assertEquals($index, $i++);
            };
        };

        $this->parentType
            ->expects(static::once())
            ->method('buildGridView')
            ->with($view, $grid, $options)
            ->willReturnCallback($assertIndex(0));

        $this->type
            ->expects(static::once())
            ->method('buildGridView')
            ->with($view, $grid, $options)
            ->willReturnCallback($assertIndex(1));

        $this->extension1
            ->expects(static::once())
            ->method('buildGridView')
            ->with($view, $grid, $options)
            ->willReturnCallback($assertIndex(2));

        $this->extension2
            ->expects(static::once())
            ->method('buildGridView')
            ->with($view, $grid, $options)
            ->willReturnCallback($assertIndex(3));

        $this->resolvedType->buildGridView($view, $grid, $options);
    }
}
