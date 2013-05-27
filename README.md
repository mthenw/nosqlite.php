# NoSQLite – simple key => value store based on SQLite3

[![Build Status](https://secure.travis-ci.org/mthenw/nosqlite.php.png)](https://travis-ci.org/mthenw/nosqlite.php)

## Introduction

NoSQLite is simple key-value store using SQLite as raw data store. Mainly for small project where MySQL is too heavy and files are too ugly.

## Requirements

- PHP >=5.3.2
    - PDO (by default as of PHP 5.1.0)
    - PDO_SQLITE (by default as of PHP 5.1.0)

## Composer package

[mthenw/nosqlite](http://packagist.org/packages/mthenw/nosqlite)

## Usage

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

7. Iterate through store

        foreach($store as $key => $value)    // Implements Iterator interface
            ...

8. Get number of values in store

        count($store);    // Implements Countable interface

## License

(The MIT License)

Copyright 2011 Maciej Winnicki http://maciejwinnicki.pl

This project is free software released under the MIT/X11 license:

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
