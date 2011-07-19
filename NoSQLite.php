<?php

require_once 'NoSQLite/Collection.php';

/**
 * SQLite wrapper for key-value stores.
 */
class NoSQLite
{
    /**
     * PDO instance
     * @var PDO
     */
    protected $_db = null;
    
    /**
     * Create NoSQLite instance
     * 
     * @param string $filename datastore file path
     */
    public function __construct($filename)
    {
        $this->_db = new PDO('sqlite:' . $filename);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get NoSQLite collection instance
     * 
     * @param string $collectionName
     * @return NoSQLite_Collection
     */
    public function getCollection($collectionName)
    {
        $collection = new NoSQLite_Collection($this->_db, $collectionName);
        return $collection;
    }
}