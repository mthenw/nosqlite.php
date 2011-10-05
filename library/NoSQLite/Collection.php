<?php
namespace NoSQLite;

/**
 * NoSQLite key-value collection
 */
class Collection implements \Iterator
{
    /**
     * PDO instance
     * @var PDO
     */
    protected $_db = null;

    /**
     * Collection name
     * @var string
     */
    protected $_name = null;

    /**
     * Key column name
     * @var string
     */
    protected $_keyColumnName = 'key';

    /**
     * Value column name
     * @var string
     */
    protected $_valueColumnName = 'value';

    /**
     * Documents stored in collection
     * @var array 
     */
    protected $_data = array();

    /**
     * Data were loaded from DB
     * @var bool
     */
    protected $_loaded = false;

    /**
     * Create collection
     *
     * @param PDO $db PDO database instance
     * @param string $name collection name 
     */
    public function __construct($db, $name)
    {
        $this->_db = $db;
        $this->_name = $name;
        $this->_createTable();
    }

    /**
     * Rewind the Iterator to the first element
     */
    public function rewind()
    {
        reset($this->_data);
    }

    /**
     * Return the current element
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->_data);
    }

    /**
     * Return the key of the current element
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->_data);
    }

    /**
     * Move forward to next element
     */
    public function next()
    {
        next($this->_data);
    }

    /**
     * Checks if current position is valid
     *
     * @return boolean The return value will be casted to boolean and then evaluated. Returns TRUE on success or FALSE
     * on failure.
     */
    public function valid()
    {
        return key($this->_data) !== null;
    }
    
    /**
     * Create storage table in database if not exists
     */
    protected function _createTable()
    {
        $stmt = 'CREATE TABLE IF NOT EXISTS "' . $this->_name;
        $stmt.= '" ("' . $this->_keyColumnName . '" TEXT PRIMARY KEY, "';
        $stmt.= $this->_valueColumnName . '" TEXT);';
        $this->_db->exec($stmt);
    }

    /**
     * Get value for specified key
     *
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    public function get($key)
    {
        if (!is_string($key))
        {
            throw new \InvalidArgumentException('Expected string as key');
        }

        if (!$this->_loaded)
        {
            $stmt = $this->_db->prepare('SELECT * FROM ' . $this->_name . ' WHERE ' . $this->_keyColumnName . ' = :key;');
            $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
            $stmt->execute();

            if ($row = $stmt->fetch(\PDO::FETCH_NUM))
            {
                $this->_data[$row[0]] = $row[1];
            }
        }

        if (isset($this->_data[$key]))
        {
            return $this->_data[$key];
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
        if (!$this->_loaded)
        {
            $stmt = $this->_db->prepare('SELECT * FROM ' . $this->_name);
            $stmt->execute();

            while ($row = $stmt->fetch(\PDO::FETCH_NUM, \PDO::FETCH_ORI_NEXT)) {
                $this->_data[$row[0]] = $row[1];
            }
        }

        return $this->_data;
    }

    /**
     * Set value on specified key
     *
     * @param string $key
     * @param string $value
     * @return string value stored in collection
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        if (!is_string($key))
        {
            throw new \InvalidArgumentException('Expected string as key');
        }

        if (!is_string($value))
        {
            throw new \InvalidArgumentException('Expected string as value');
        }

        if (isset($this->_data[$key]))
        {
            $queryString ='UPDATE ' . $this->_name . ' SET ' . $this->_valueColumnName . ' = :value WHERE ';
            $queryString.= $this->_keyColumnName . ' = :key;';
        }
        else
        {
            $queryString = 'INSERT INTO ' . $this->_name . ' VALUES (:key, :value);';
        }

        $stmt = $this->_db->prepare($queryString);
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
        $stmt->bindParam(':value', $value, \PDO::PARAM_STR);
        $stmt->execute();
        $this->_data[(string)$key] = $value;

        return $this->_data[$key];
    }

    /**
     * Delete value from collection
     *
     * @param string $key 
     */
    public function delete($key)
    {
        $stmt = $this->_db->prepare('DELETE FROM ' . $this->_name . ' WHERE ' . $this->_keyColumnName . ' = :key;');
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
        $stmt->execute();

        unset($this->_data[$key]);
    }

    /**
     * Delete all values from collection
     */
    public function deleteAll()
    {
        $stmt = $this->_db->prepare('DELETE FROM ' . $this->_name);
        $stmt->execute();
        $this->_data = array();
    }
}