<?php

namespace PETest\Component\Grid\DataSource;

use PE\Component\Grid\DataSource\AbstractDataSource;

class AbstractDataSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractDataSource|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataSource;

    protected function setUp()
    {
        $this->dataSource = $this->getMockForAbstractClass(AbstractDataSource::class);
    }

    public function testSimpleKeyValue()
    {
        $this->dataSource->setCriteria(['foo' => 'bar']);
        static::assertEquals([['foo', '==', 'bar']], $this->dataSource->getCriteria());
    }

    public function testNumericKeyValueBypass()
    {
        $this->dataSource->setCriteria([['foo', '==', 'bar']]);
        static::assertEquals([['foo', '==', 'bar']], $this->dataSource->getCriteria());
    }

    public function testSimpleKeyValueIgnoredIfEmpty()
    {
        $this->dataSource->setCriteria(['foo' => '']);
        static::assertEquals([], $this->dataSource->getCriteria());
    }

    public function testNumericKeyAndNotAnArrayIgnored()
    {
        $this->dataSource->setCriteria(['foo']);
        static::assertEquals([], $this->dataSource->getCriteria());
    }

    public function testCustom1CharCompare()
    {
        $this->dataSource->setCriteria(['foo>' => 'bar']);
        static::assertEquals([['foo', '>', 'bar']], $this->dataSource->getCriteria());
    }

    public function testCustom2CharCompare()
    {
        $this->dataSource->setCriteria(['foo>=' => 'bar']);
        static::assertEquals([['foo', '>=', 'bar']], $this->dataSource->getCriteria());
    }
}
