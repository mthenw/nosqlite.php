<?php

/**
 * NoSQLite
 * Simple key => value store based on SQLite3
 *
 * PHP Version 5
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */

namespace NoSQLite;

use NoSQLite\Store;

/**
 * Class NoSQLite
 * Managing class for key-value store
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */
class NoSQLite
{
    /**
     * PDO instance
     * @var PDO
     */
    protected $db = null;
    
    /**
     * Create NoSQLite instance
     * 
     * @param string $filename datastore file path
     */
    public function __construct($filename)
    {
        $this->db = new \PDO('sqlite:' . $filename);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get NoSQLite store instance
     * 
     * @param string $storeName store name
     *
     * @return \NoSQLite\Store
     */
    public function getStore($storeName)
    {
        $store = new Store($this->db, $storeName);
        return $store;
    }
}