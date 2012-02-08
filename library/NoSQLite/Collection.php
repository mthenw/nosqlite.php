<?php

/**
 * Collection
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

require_once __DIR__ . '/../NoSQLite.php';

/**
 * Class Collection
 *
 * @category NoSQLite
 * @package  NoSQLite
 * @author   Maciej Winnicki <maciej.winnicki@gmail.com>
 * @license  https://github.com/mthenw/NoSQLite-for-PHP The MIT License
 * @link     https://github.com/mthenw/NoSQLite-for-PHP
 */
class Collection
{
    /**
     * PDO instance
     * @var PDO
     */
    protected $db = null;

    /**
     * Collection name
     * @var string
     */
    protected $name = null;

    /**
     * Key column name
     * @var string
     */
    protected $keyColumnName = 'key';

    /**
     * Value column name
     * @var string
     */
    protected $valueColumnName = 'value';

    /**
     * Documents stored in collection
     * @var array 
     */
    protected $data = array();

    /**
     * Data were loaded from DB
     * @var bool
     */
    protected $loaded = false;

    /**
     * Create collection
     *
     * @param PDO    $db   PDO database instance
     * @param string $name collection name
     *
     * @return void
     */
    public function __construct($db, $name)
    {
        $this->db = $db;
        $this->name = $name;
        $this->createTable();
    }

    /**
     * Create storage table in database if not exists
     *
     * @return void
     */
    protected function createTable()
    {
        $stmt = 'CREATE TABLE IF NOT EXISTS "' . $this->name;
        $stmt.= '" ("' . $this->keyColumnName . '" TEXT PRIMARY KEY, "';
        $stmt.= $this->valueColumnName . '" TEXT);';
        $this->db->exec($stmt);
    }

    /**
     * Get value for specified key
     *
     * @param string $key key
     *
     * @throws InvalidArgumentException
     * @return string|null
     */
    public function get($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Expected string as key');
        }

        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else if (!$this->loaded) {
            $stmt = $this->db->prepare(
                'SELECT * FROM ' . $this->name . ' WHERE ' . $this->keyColumnName
                . ' = :key;'
            );
            $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
            $stmt->execute();

            if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
                $this->data[$row[0]] = $row[1];
                return $this->data[$key];
            }
        }

        return null;
    }

    /**
     * Get all values as array with key => value structure
     *
     * @return array
     */
    public function getAll()
    {
        if (!$this->loaded) {
            $stmt = $this->db->prepare('SELECT * FROM ' . $this->name);
            $stmt->execute();

            while ($row = $stmt->fetch(\PDO::FETCH_NUM, \PDO::FETCH_ORI_NEXT)) {
                $this->data[$row[0]] = $row[1];
            }
        }

        return $this->data;
    }

    /**
     * Set value on specified key
     *
     * @param string $key   key
     * @param string $value value
     *
     * @return string value stored in collection
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Expected string as key');
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException('Expected string as value');
        }

        if (isset($this->data[$key])) {
            $queryString ='UPDATE ' . $this->name . ' SET ';
            $queryString.= $this->valueColumnName . ' = :value WHERE ';
            $queryString.= $this->keyColumnName . ' = :key;';
        } else {
            $queryString = 'INSERT INTO ' . $this->name . ' VALUES (:key, :value);';
        }

        $stmt = $this->db->prepare($queryString);
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, \PDO::PARAM_STR);
        $stmt->execute();
        $this->data[(string)$key] = $value;

        return $this->data[$key];
    }

    /**
     * Delete value from collection
     *
     * @param string $key key
     *
     * @return void
     */
    public function delete($key)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM ' . $this->name . ' WHERE ' . $this->keyColumnName
            . ' = :key;'
        );
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
        $stmt->execute();

        unset($this->data[$key]);
    }

    /**
     * Delete all values from collection
     *
     * @return void
     */
    public function deleteAll()
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $this->name);
        $stmt->execute();
        $this->data = array();
    }
}