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

require_once '../library/NoSQLite.php';

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
     * Test creating new collection
     *
     * @return void
     */
    public function testNewCollection()
    {
        $nsl = new NoSQLite\NoSQLite(self::DB_FILE);
        $collection = $nsl->getCollection('test');
        $this->assertEquals(get_class($collection), 'NoSQLite\Collection');
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