<?php

/**
 * NoSQLite Store Test
 *
 * PHP Version 5
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */

namespace NoSQLite\Tests;

use PHPUnit_Framework_TestCase;
use NoSQLite\NoSQLite;
use NoSQLite\Store;

/**
 * Class StoreTest
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */
class StoreTest extends \PHPUnit_Framework_TestCase
{
    const DB_FILE = 'storeTest.db';

    /**
     * @var NoSQLite\NoSQLite
     */
    protected $nsl;

    /**
     * @var NoSQLite\Store
     */
    protected $store;

    /**
     * Setup test
     *
     * @return void
     */
    public function setUp()
    {
        $this->nsl = new NoSQLite(self::DB_FILE);
        $this->store = $this->nsl->getStore('test');
    }

    /**
     * Test first get
     *
     * @return void
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
     * Test getting all values
     *
     * @return void
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
     * Test getting and setting value
     *
     * @param string $key   key
     * @param string $value value
     *
     * @dataProvider validData
     * @return void
     */
    public function testSetGetValue($key, $value)
    {
        $this->store->set($key, $value);
        $this->assertEquals($this->store->get($key), $value);
    }

    /**
     * Test updating earlier set value
     *
     * @return void
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
     * Test set method exception
     *
     * @param string $key   key
     * @param string $value value
     *
     * @dataProvider invalidSetData
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testSetExceptions($key, $value)
    {
        $this->store->set($key, $value);
        $this->store->get($key);
    }

    /**
     * Test get method exception
     *
     * @param string $key key
     *
     * @dataProvider invalidGetData
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testGetExceptions($key)
    {
        $this->store->get($key);
    }

    /**
     * Test delete value
     *
     * @return void
     */
    public function testDelete()
    {
        $key = uniqid();
        $this->store->set($key, 'value');
        $this->store->delete($key);
        $this->assertEquals(null, $this->store->get($key));
    }

    /**
     * Test all values
     *
     * @return void
     */
    public function testDeleteAll()
    {
        $this->store->set(uniqid(), 'value');
        $this->store->deleteAll();
        $this->assertEquals(array(), $this->store->getAll());
    }

    /**
     * Test Countable interface
     *
     * @return void
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
     * Data provider - valid data
     *
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
     * Data provider - invalid set data
     *
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
     * Data provider - invalid get data
     *
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
     * Tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->nsl);
        unset($this->store);
        unlink(self::DB_FILE);
    }
}
