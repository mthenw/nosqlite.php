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

require_once 'NoSQLite/Collection.php';

/**
 * Class NoSQLite
 * Managing class key-value collections
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
     * Get NoSQLite collection instance
     * 
     * @param string $collectionName collection name
     *
     * @return \NoSQLite\Collection
     */
    public function getCollection($collectionName)
    {
        $collection = new \NoSQLite\Collection($this->db, $collectionName);
        return $collection;
    }
}