<?php

namespace PETest\Component\Grid\DataSource;

use PE\Component\Grid\DataSource\ArrayDataSource;

class ArrayDataSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var ArrayDataSource
     */
    protected $dataSource;

    protected function setUp()
    {
        $this->data = [
            ['foo' => 'foo1'],
            ['foo' => 'foo2'],
            ['foo' => 'foo3'],
            ['foo' => 'foo4'],
            ['foo' => 'foo5'],
            ['foo' => 'foo6'],
        ];

        $this->dataSource = new ArrayDataSource($this->data);
    }

    public function testApi()
    {
        static::assertCount(6, $this->dataSource);

        foreach ($this->dataSource as $key => $item) {
            static::assertArrayHasKey($key, $this->data);
            static::assertEquals($this->data[$key], $item);
        }
    }

    public function testFilter()
    {
        $this->dataSource->setCriteria(['foo' => 'foo1']);

        $this->dataSource->rewind();
        static::assertCount(1, $this->dataSource);
        static::assertEquals(['foo' => 'foo1'], $this->dataSource->current());
    }

    public function testNotFilterIfItemsIsNotAnArrays()
    {
        $this->dataSource = new ArrayDataSource([new \stdClass(), new \stdClass()]);

        $this->dataSource->setCriteria(['foo' => 'foo1']);

        $this->dataSource->rewind();
        static::assertCount(2, $this->dataSource);
    }

    public function testNotFilterIfItemHasNotKey()
    {
        $this->dataSource->setCriteria(['bar' => 'foo1']);

        $this->dataSource->rewind();
        static::assertCount(6, $this->dataSource);
    }

    public function testSorting()
    {
        $this->dataSource->setOrderBy(['foo' => 'desc']);

        $this->dataSource->rewind();
        static::assertEquals(['foo' => 'foo6'], $this->dataSource->current());

        $this->dataSource->setOrderBy(['foo' => 'asc']);

        $this->dataSource->rewind();
        static::assertEquals(['foo' => 'foo1'], $this->dataSource->current());
    }

    public function testLimitAndOffset()
    {
        $this->dataSource->setOffset(1);
        $this->dataSource->setLimit(3);

        static::assertCount(3, $this->dataSource);
        static::assertEquals(['foo' => 'foo2'], $this->dataSource->current());
    }
}
