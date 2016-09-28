<?php

use Andaniel05\ObjectCollection\ObjectCollection as Collection;

class MyClass {};
class MyOtherClass {};
interface MyInterface {};

class ObjectCollectionTest extends PHPUnit_Framework_TestCase
{
    public function getCollection()
    {
        return new Collection('MyClass');
    }

    /**
     * @expectedException Andaniel05\ObjectCollection\Exception\ClassNotFoundException
     */
    public function testThrowClassNotFoundException()
    {
        $collection = new Collection('ClassNotFound');
    }

    public function testGetClassName()
    {
        $this->assertEquals('MyClass', $this->getCollection()->getClass());
    }

    /**
     * @expectedException Andaniel05\ObjectCollection\Exception\InvalidObjectTypeException
     */
    public function testThrowInvalidObjectTypeExceptionOnInsertion()
    {
        $dummy = new MyOtherClass;

        $collection = $this->getCollection();
        $collection['dummy'] = $dummy;
    }

    public function testOffsetMethods()
    {
        $dummy = new MyClass;
        $collection = $this->getCollection();

        $collection['dummy'] = $dummy; // offsetSet

        $this->assertTrue(isset($collection['dummy'])); // offsetExists
        $this->assertSame($dummy, $collection['dummy']); // offsetGet

        unset($collection['dummy']);

        $this->assertFalse(isset($collection['dummy'])); // offsetUnset
    }

    public function testCount()
    {
        $dummy = new MyClass;
        $collection = $this->getCollection();

        $collection['dummy'] = $dummy;

        $this->assertCount(1, $collection);
    }

    public function testGetArray()
    {
        $dummy = new MyClass;
        $collection = $this->getCollection();

        $collection['dummy'] = $dummy;
        $array = $collection->getArray();

        $this->assertArrayHasKey('dummy', $array);
        $this->assertSame($dummy, $collection['dummy']);
    }

    public function testForEach()
    {
        $dummy1 = new MyClass;
        $dummy2 = new MyClass;
        $dummy3 = new MyClass;
        $collection = $this->getCollection();

        $collection['dummy1'] = $dummy1;
        $collection['dummy2'] = $dummy2;
        $collection['dummy3'] = $dummy3;

        $arr = array();
        foreach ($collection as $key => $obj) {
            $arr[$key] = $obj;
        }

        $this->assertCount(3, $arr);
        $this->assertArrayHasKey('dummy1', $arr);
        $this->assertSame($dummy1, $arr['dummy1']);
        $this->assertArrayHasKey('dummy2', $arr);
        $this->assertSame($dummy2, $arr['dummy2']);
        $this->assertArrayHasKey('dummy3', $arr);
        $this->assertSame($dummy3, $arr['dummy3']);
    }

    public function testInterfaceSupport()
    {
        $collection = new Collection('MyInterface');
    }

    public function testInsertWithoutIndex()
    {
        $dummy = new MyClass;
        $collection = $this->getCollection();

        $collection[] = $dummy;

        $this->assertSame($dummy, $collection[0]);
    }
}