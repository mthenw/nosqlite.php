<?php
require_once '../library/NoSQLite.php';
require_once '../library/NoSQLite/Collection.php';

class CollectionTest extends PHPUnit_Framework_TestCase
{
    const DB_FILE = 'testCollectionTest.db';

    protected $_nsl;
    protected $_collection;

    public function setUp()
    {
        $this->_nsl = new NoSQLite\NoSQLite(self::DB_FILE);
        $this->_collection = $this->_nsl->getCollection('test');
    }

    /**
     * @dataProvider validData
     */
    public function testSetGetValue($key, $value)
    {
        $this->_collection->set($key, $value);
        $this->assertEquals($this->_collection->get($key), $value);
    }

    /**
     * @dataProvider inValidData
     * @expectedException InvalidArgumentException
     */
    public function testSetGetExceptions($key, $value)
    {
        $this->_collection->set($key, $value);
        $this->_collection->get($key);
    }

    public function testDeleteAll()
    {
        $this->_collection->set(uniqid(), 'value');
        $this->_collection->deleteAll();
        $this->assertEquals(array(), $this->_collection->getAll());
    }

    public function testGetAll()
    {
        $data = array(
            '_1' => 'value1',
            '_2' => 'value2'
        );

        $this->_collection->deleteAll();

        foreach($data as $key => $value)
        {
            $this->_collection->set($key, $value);
        }

        $this->assertEquals($data, $this->_collection->getAll());
    }

    public static function validData()
    {
        return array(
            array('key', 'value'),
            array('0', 'value'),
        );
    }

    public static function inValidData()
    {
        return array(
            array(0, 'value'),
            array('key', 0)
        );
    }

    public function tearDown()
    {
        unlink(self::DB_FILE);
    }
}
