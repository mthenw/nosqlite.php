<?php

namespace NoSQLite\Tests;

use PHPUnit_Framework_TestCase;
use NoSQLite\NoSQLite;
use NoSQLite\Store;

class StoreTest extends \PHPUnit_Framework_TestCase
{
    const DB_FILE = 'storeTest.db';

    /**
     * @var NoSQLite
     */
    protected $nsl;

    /**
     * @var Store
     */
    protected $store;

    /**
     * @return null
     */
    public function setUp()
    {
        $this->nsl = new NoSQLite(self::DB_FILE);
        $this->store = $this->nsl->getStore('test');
    }

    /**
     * @return null
     */
    public function testFirstGet()
    {
        $key = uniqid();
        $value = 'value';

        $this->store->set($key, $value);
        $this->setUp();
        $this->assertEquals($this->store->get($key), $value);
    }

    /**
     * @return null
     */
    public function testGetAll()
    {
        $data = array(
            '_1' => 'value1',
            '_2' => 'value2'
        );

        $this->store->deleteAll();

        foreach ($data as $key => $value) {
            $this->store->set($key, $value);
        }

        $this->assertEquals($data, $this->store->getAll());
    }

    /**
     * @param string $key key
     * @param string $value value
     *
     * @dataProvider validData
     * @return null
     */
    public function testSetGetValue($key, $value)
    {
        $this->store->set($key, $value);
        $this->assertEquals($this->store->get($key), $value);
    }

    /**
     * @return null
     */
    public function testUpdateValue()
    {
        $key = uniqid();
        $value1 = uniqid();
        $value2 = uniqid();
        $this->store->set($key, $value1);
        $this->store->set($key, $value2);
        $this->assertEquals($value2, $this->store->get($key));
    }

    /**
     * Test updating earlier set value from a new store without cache
     *
     * @return void
     */
    public function testSetExisting()
    {
        $key = uniqid();
        $value1 = uniqid();
        $value2 = uniqid();
        $this->store->set($key, $value1);
        $newStore = $this->nsl->getStore('test');
        $newStore->set($key, $value2);
        $this->assertEquals($value2, $newStore->get($key));
    }

    /**
     * @param string $key key
     * @param string $value value
     *
     * @dataProvider invalidSetData
     * @expectedException \InvalidArgumentException
     * @return null
     */
    public function testSetExceptions($key, $value)
    {
        $this->store->set($key, $value);
        $this->store->get($key);
    }

    /**
     * @param string $key key
     *
     * @dataProvider invalidGetData
     * @expectedException \InvalidArgumentException
     * @return null
     */
    public function testGetExceptions($key)
    {
        $this->store->get($key);
    }

    /**
     * @return null
     */
    public function testDelete()
    {
        $key = uniqid();
        $this->store->set($key, 'value');
        $this->store->delete($key);
        $this->assertEquals(null, $this->store->get($key));
    }

    /**
     * @return null
     */
    public function testDeleteAll()
    {
        $this->store->set(uniqid(), 'value');
        $this->store->deleteAll();
        $this->assertEquals(array(), $this->store->getAll());
    }

    /**
     * @return null
     */
    public function testCount()
    {
        $count = rand(1, 100);
        for ($i = 0; $i < $count; $i++) {
            $this->store->set(uniqid(), uniqid());
        }
        $this->assertEquals($count, count($this->store));
    }

    /**
     * @return null
     */
    public function testIteration()
    {
        $this->store->set('key1', 'value1');

        foreach ($this->store as $key => $value) {
            $this->assertSame($key, 'key1');
            $this->assertSame($value, 'value1');
        }
    }

    /**
     * @static
     * @return array
     */
    public static function validData()
    {
        return array(
            array('key', 'value'),
            array('0', 'value'),
        );
    }

    /**
     * @static
     * @return array
     */
    public static function invalidSetData()
    {
        return array(
            array(0, 'value'),
            array('key', 1),
        );
    }

    /**
     * @static
     * @return array
     */
    public static function invalidGetData()
    {
        return array(
            array(10),
        );
    }

    /**
     * @return null
     */
    public function tearDown()
    {
        unset($this->nsl);
        unset($this->store);
        unlink(self::DB_FILE);
    }
}
