<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\ColumnExtensionInterface;
use PE\Component\Grid\ColumnTypeInterface;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\GridExtensionInterface;
use PE\Component\Grid\GridType;
use PE\Component\Grid\ColumnType;
use PE\Component\Grid\GridTypeInterface;
use PE\Component\Grid\Registry;
use PE\Component\Grid\ResolvedColumnTypeInterface;
use PE\Component\Grid\ResolvedGridTypeInterface;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyRegistry()
    {
        $registry = new Registry([], []);

        static::assertFalse($registry->hasGridType('NotFoundType'));
        static::assertFalse($registry->hasColumnType('NotFoundType'));

        static::assertCount(0, $registry->getGridExtensions());
        static::assertCount(0, $registry->getColumnExtensions());
    }

    public function testConstructRegistryWithInvalidGridExtensionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Registry([1], []);
    }

    public function testConstructRegistryWithInvalidColumnExtensionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Registry([], [1]);
    }

    public function testGetUndefinedGridTypeThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $registry = new Registry([], []);
        $registry->getGridType('NotFoundType');
    }

    public function testGetBaseGridType()
    {
        $registry = new Registry([], []);
        $type1    = $registry->getGridType(GridType\BaseType::class);

        static::assertInstanceOf(ResolvedGridTypeInterface::class, $type1);

        $type2 = $registry->getGridType(GridType\BaseType::class);

        static::assertEquals($type2, $type1);
    }

    public function testGetGridTypeFromExtension()
    {
        $type = $this->createMock(GridTypeInterface::class);

        $extension = $this->createMock(GridExtensionInterface::class);

        $extension
            ->method('hasType')
            ->willReturnCallback(function($name) use ($type) {
                return true;
            }
        );

        $extension
            ->method('getType')
            ->willReturnCallback(function($name) use ($type) {
                return $type;
            }
        );

        $extension
            ->method('getTypeExtensions')
            ->willReturnCallback(function(){
                return [];
            }
        );

        $registry = new Registry([$extension], []);

        static::assertEquals($type, $registry->getGridType('foo')->getInnerType());
    }

    public function testHasGridType()
    {
        $registry = new Registry([], []);

        static::assertFalse($registry->hasGridType('undefined'));
        static::assertTrue($registry->hasGridType(GridType\BaseType::class));
        static::assertTrue($registry->hasGridType(GridType\BaseType::class));
    }

    public function testGetUndefinedColumnTypeThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $registry = new Registry([], []);
        $registry->getColumnType('NotFoundType');
    }

    public function testGetBaseColumnType()
    {
        $registry = new Registry([], []);
        $type1    = $registry->getColumnType(ColumnType\BaseType::class);

        static::assertInstanceOf(ResolvedColumnTypeInterface::class, $type1);

        $type2 = $registry->getColumnType(ColumnType\BaseType::class);

        static::assertEquals($type2, $type1);
    }

    public function testGetColumnTypeFromExtension()
    {
        $type = $this->createMock(ColumnTypeInterface::class);

        $extension = $this->createMock(ColumnExtensionInterface::class);

        $extension
            ->method('hasType')
            ->willReturnCallback(function($name) use ($type) {
                return true;
            }
            );

        $extension
            ->method('getType')
            ->willReturnCallback(function($name) use ($type) {
                return $type;
            }
            );

        $extension
            ->method('getTypeExtensions')
            ->willReturnCallback(function(){
                return [];
            }
            );

        $registry = new Registry([], [$extension]);

        static::assertEquals($type, $registry->getColumnType('foo')->getInnerType());
    }

    public function testHasColumnType()
    {
        $registry = new Registry([], []);

        static::assertFalse($registry->hasColumnType('undefined'));
        static::assertTrue($registry->hasColumnType(ColumnType\BaseType::class));
        static::assertTrue($registry->hasColumnType(ColumnType\BaseType::class));
    }
}
