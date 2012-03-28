# NoSQLite – simple key => value store based on SQLite3

[![Build Status](https://secure.travis-ci.org/mthenw/nosqlite.php.png)](https://secure.travis-ci.org/mthenw/nosqlite.php)

## Introduction

NoSQLite is simple key-value store using SQLite as raw data store. Mainly for small project where MySQL is too heavy and files are too ugly.

## Requirements

- PHP >=5.3.2
    - PDO (by default as of PHP 5.1.0)
    - PDO_SQLITE (by default as of PHP 5.1.0)

## How to use

1. Create stores' manager (file will be created if not exists)

        $nsql = new NoSQLite\NoSQLite('mydb.sqlite');

2. Get store

        $store = $nsql->getStore('movies');

3. Set value in store (key and value max length are [limited by SQLite TEXT datatype](http://sqlite.org/limits.html#max_length))

        $store->set(uniqid(), json_encode(array('title' => 'Good Will Hunting', 'director' => 'Gus Van Sant'));

4. Get value from store (will be created if not exists)

        $store->get('3452345');

5.  Get all values

        $store->getAll();

6. Delete all values

        $store->deleteAll();

