<?php
require_once '../NoSQLite.php';

class NoSQLiteTest extends PHPUnit_Framework_TestCase
{
    const DB_FILE = 'testNoSQLiteTest.db';

    public function testNewCollection()
    {
        $nsl = new NoSQLite\NoSQLite(self::DB_FILE);
        $collection = $nsl->getCollection('test');
        $this->assertEquals(get_class($collection), 'NoSQLite\Collection');
    }

    public function tearDown()
    {
        unlink(self::DB_FILE);
    }
}