<?php

/**
 * NoSQLite Test
 *
 * PHP Version 5
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */

require_once __DIR__ . '/../library/NoSQLite.php';

/**
 * Class NoSQLiteTest
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */
class NoSQLiteTest extends \PHPUnit_Framework_TestCase
{
    const DB_FILE = 'testNoSQLiteTest.db';

    /**
     * Test creating new store
     *
     * @return void
     */
    public function testNewStore()
    {
        $nsl = new NoSQLite\NoSQLite(self::DB_FILE);
        $store = $nsl->getStore('test');
        $this->assertEquals(get_class($store), 'NoSQLite\Store');
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