<?php

namespace Jimenezmaximiliano\Tests;

use Jimenezmaximiliano\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /** @var  array */
    private $mixedArray;
    /** @var  Collection */
    private $mixedArrayCollection;
    /** @var  array */
    private $numericArray;
    /** @var  Collection */
    private $numericArrayCollection;

    public function setUp()
    {
        $this->mixedArray = [
            1,
            2,
            3,
            'key' => 4,
            'anotherKey' => 'string',
        ];
        $this->mixedArrayCollection = new Collection($this->mixedArray);
        $this->numericArray = [1, 2, 3, 4];
        $this->numericArrayCollection = new Collection($this->numericArray);
    }

    public function testEach()
    {
        $resultArray = [];
        $this->mixedArrayCollection->each(function ($value, $key) use (&$resultArray) {
            $resultArray[$key] = $value;
        });

        $this->assertEquals($this->mixedArray, $resultArray);
    }

    public function testPush()
    {
        $this->mixedArray[] = 'test';
        $this->mixedArrayCollection->push('test');

        $this->assertEquals($this->mixedArray, $this->mixedArrayCollection->all());
    }

    public function testMap()
    {
        $resultCollection = $this->numericArrayCollection->map(function ($number) {
            return ++$number;
        });
        $expected = [2, 3, 4 , 5];

        $this->assertEquals($expected, $resultCollection->all());
    }

    public function testMerge()
    {
        $resultCollection = $this->numericArrayCollection->merge([5]);
        $expected = [1, 2, 3, 4, 5];

        $this->assertEquals($expected, $resultCollection->all());
    }

    public function testPut()
    {
        $this->mixedArrayCollection->put('test', 'test');
        $this->mixedArray['test'] = 'test';

        $this->assertEquals($this->mixedArray, $this->mixedArrayCollection->all());
    }

    public function testAll()
    {
        $this->assertEquals($this->mixedArray, $this->mixedArrayCollection->all());
    }

    public function testToArray()
    {
        $this->assertEquals($this->mixedArray, $this->mixedArrayCollection->toArray());
    }

    public function testHasKeyWithKey()
    {
        $this->assertTrue($this->mixedArrayCollection->hasKey('key'));
    }

    public function testHasKeyWithoutKey()
    {
        $this->assertFalse($this->mixedArrayCollection->hasKey('someRandomKey'));
    }

    public function testHasValueWithValue()
    {
        $this->assertTrue($this->numericArrayCollection->hasValue(1));
    }

    public function testHasValueWithoutValue()
    {
        $this->assertFalse($this->numericArrayCollection->hasValue(5));
    }

    public function testCount()
    {
        $this->assertEquals($this->numericArrayCollection->count(), 4);
    }

    public function testFilter()
    {
        $expected = [1, 2];
        $resultCollection = $this->numericArrayCollection->filter(function ($number) {
            return $number < 3;
        });

        $this->assertEquals($expected, $resultCollection->all());
    }

    public function testRejectIndexed()
    {
        $expected = [3, 4];
        $resultCollection = $this->numericArrayCollection->reject(function ($number) {
            return $number < 3;
        });

        $this->assertEquals($expected, $resultCollection->all());
    }

    public function testRejectAssociative()
    {
        $expected = ['anotherKey' => 'string'];
        $resultCollection = $this->mixedArrayCollection->reject(function ($value, $key) {
            return is_numeric($value);
        });

        $this->assertEquals($expected, $resultCollection->all());
    }

    public function testFirst()
    {
        $this->assertEquals(1, $this->numericArrayCollection->first());
    }

    public function testGet()
    {
        $this->assertEquals(4, $this->mixedArrayCollection->get('key'));
    }

    public function testImplode()
    {
        $this->assertEquals('1.2.3.4', $this->numericArrayCollection->implode('.'));
    }

    public function testIsEmpty()
    {
        $this->assertFalse($this->numericArrayCollection->isEmpty());
    }

    public function testIsNotEmpty()
    {
        $emptyCollection = new Collection;

        $this->assertFalse($emptyCollection->isNotEmpty());
    }

    public function testKeys()
    {
        $expected = [0, 1, 2, 'key', 'anotherKey'];

        $this->assertEquals($expected, $this->mixedArrayCollection->keys()->all());
    }

    public function testValues()
    {
        $expected = [1, 2, 3, 4, 'string'];

        $this->assertEquals($expected, $this->mixedArrayCollection->values()->all());
    }

    public function testReduce()
    {
        $result = $this->numericArrayCollection->reduce(function ($value, $initial) {
            return $initial + $value;
        }, 0);

        $this->assertEquals(10, $result);
    }
}
