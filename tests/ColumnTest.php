<?php

namespace PETest\Component\Grid;

use PE\Component\Grid\Column;
use PE\Component\Grid\DataMapper\DataMapperInterface;
use PE\Component\Grid\DataMapper\ReflectionDataMapper;
use PE\Component\Grid\ResolvedColumnTypeInterface;

class ColumnTest extends \PHPUnit_Framework_TestCase
{
    public function testColumn()
    {
        $name    = 'foo';
        $type    = $this->createMock(ResolvedColumnTypeInterface::class);
        $options = ['bar' => 'baz'];

        $column = new Column($name, $type, $options);

        static::assertEquals($name, $column->getName());
        static::assertEquals($type, $column->getType());
        static::assertEquals($options, $column->getOptions());
    }

    public function testDataMapper()
    {
        $name    = 'foo';
        $type    = $this->createMock(ResolvedColumnTypeInterface::class);
        $options = ['bar' => 'baz'];

        $column = new Column($name, $type, $options);

        static::assertInstanceOf(ReflectionDataMapper::class, $column->getDataMapper());

        $column->setDataMapper($mapper = $this->createMock(DataMapperInterface::class));

        static::assertEquals($mapper, $column->getDataMapper());
    }
}
