<?php

namespace NoSQLite\Tests;

use NoSQLite\NoSQLite;
use NoSQLite\Store;

class NoSQLiteTest extends \PHPUnit_Framework_TestCase
{
    const DB_FILE = 'testNoSQLiteTest.db';

    /**
     * @return null
     */
    public function testNewStore()
    {
        $nsl = new NoSQLite(self::DB_FILE);
        $store = $nsl->getStore('test');
        $this->assertEquals(get_class($store), 'NoSQLite\Store');
    }

    /**
     * @return null
     */
    public function tearDown()
    {
        unlink(self::DB_FILE);
    }
}