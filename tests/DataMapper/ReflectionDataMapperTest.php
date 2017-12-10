<?php

namespace PETest\Component\Grid\DataMapper;

use PE\Component\Grid\DataMapper\ReflectionDataMapper;
use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\RuntimeException;
use PE\Component\Grid\Exception\UnexpectedValueException;

class ReflectionDataMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReflectionDataMapper
     */
    protected $mapper;

    protected function setUp()
    {
        $this->mapper = new ReflectionDataMapper();
    }

    public function testGetValueThrowsExceptionIfNotAnObject()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->mapper->getValue(false, false);
    }

    public function testGetValueThrowsExceptionIfArrayHasNotKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->mapper->getValue([], 'foo');
    }

    public function testGetValueThrowsExceptionIfCannotSet()
    {
        $this->expectException(RuntimeException::class);
        $this->mapper->getValue(new \stdClass(), 'foo');
    }

    public function testGetValueFromArray()
    {
        $data = ['foo' => 'bar'];
        static::assertEquals('bar', $this->mapper->getValue($data, 'foo'));
    }

    public function testGetValueFromObjectViaProperty()
    {
        $data = new ObjectWithPublicProperty();
        $data->foo = 'bar';
        static::assertEquals('bar', $this->mapper->getValue($data, 'foo'));
    }

    public function testGetValueFromObjectViaGetter()
    {
        $data = new ObjectWithGetterAndSetter();
        $data->setFoo('bar');
        static::assertEquals('bar', $this->mapper->getValue($data, 'foo'));
    }

    public function testGetValueFromObjectViaHasser()
    {
        $data = new ObjectWithHasserAndSetter();
        $data->setFoo('bar');
        static::assertEquals('bar', $this->mapper->getValue($data, 'foo'));
    }

    public function testGetValueFromObjectViaIsser()
    {
        $data = new ObjectWithIsserAndSetter();
        $data->setFoo('bar');
        static::assertEquals('bar', $this->mapper->getValue($data, 'foo'));
    }

    public function testSetValueThrowsExceptionIfNotAnObject()
    {
        $this->expectException(UnexpectedValueException::class);
        $data = false;
        $this->mapper->setValue($data, false, false);
    }

    public function testSetValueThrowsExceptionIfCannotSet()
    {
        $this->expectException(RuntimeException::class);
        $data = new \stdClass();
        $this->mapper->setValue($data, 'foo', 'bar');
    }

    public function testSetValueToArray()
    {
        $data = [];
        $this->mapper->setValue($data, 'foo', 'bar');
        static::assertEquals(['foo' => 'bar'], $data);
    }

    public function testSetValueToObjectViaProperty()
    {
        $data = new ObjectWithPublicProperty();
        $this->mapper->setValue($data, 'foo', 'bar');
        static::assertEquals('bar', $data->foo);
    }

    public function testSetValueToObjectViaSetter()
    {
        $data = new ObjectWithGetterAndSetter();
        $this->mapper->setValue($data, 'foo', 'bar');
        static::assertEquals('bar', $data->getFoo());
    }
}

class ObjectWithPublicProperty
{
    public $foo;
}

class ObjectWithGetterAndSetter
{
    protected $foo;

    public function getFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
}

class ObjectWithHasserAndSetter
{
    protected $foo;

    public function hasFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
}

class ObjectWithIsserAndSetter
{
    protected $foo;

    public function isFoo()
    {
        return $this->foo;
    }

    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
}
