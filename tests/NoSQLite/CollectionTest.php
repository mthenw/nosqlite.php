<?php

/**
 * NoSQLite Collection Test
 *
 * PHP Version 5
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */

require_once '../library/NoSQLite.php';
require_once '../library/NoSQLite/Collection.php';

/**
 * Class CollectionTest
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */
class CollectionTest extends PHPUnit_Framework_TestCase
{
    const DB_FILE = 'testCollectionTest.db';

    /**
     * @var NoSQLite\NoSQLite
     */
    protected $nsl;

    /**
     * @var NoSQLite\Collection
     */
    protected $collection;

    /**
     * Setup test
     *
     * @return void
     */
    public function setUp()
    {
        $this->nsl = new NoSQLite\NoSQLite(self::DB_FILE);
        $this->collection = $this->nsl->getCollection('test');
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
        $this->collection->set($key, $value);
        $this->assertEquals($this->collection->get($key), $value);
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

        $this->collection->set($key, $value);
        $this->setUp();
        $this->assertEquals($this->collection->get($key), $value);
    }

    /**
     * Test exception
     *
     * @param string $key   key
     * @param string $value value
     *
     * @dataProvider inValidData
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testSetGetExceptions($key, $value)
    {
        $this->collection->set($key, $value);
        $this->collection->get($key);
    }

    /**
     * Test delete value
     *
     * @return void
     */
    public function testDelete()
    {
        $key = uniqid();
        $this->collection->set($key, 'value');
        $this->collection->delete($key);
        $this->assertEquals(null, $this->collection->get($key));
    }

    /**
     * Test all values
     *
     * @return void
     */
    public function testDeleteAll()
    {
        $this->collection->set(uniqid(), 'value');
        $this->collection->deleteAll();
        $this->assertEquals(array(), $this->collection->getAll());
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

        $this->collection->deleteAll();

        foreach ($data as $key => $value) {
            $this->collection->set($key, $value);
        }

        $this->assertEquals($data, $this->collection->getAll());
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
     * Data provider - invalid data
     *
     * @static
     * @return array
     */
    public static function inValidData()
    {
        return array(
            array(0, 'value'),
            array('key', 0)
        );
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unlink(self::DB_FILE);
    }
}
