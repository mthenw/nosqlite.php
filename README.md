# NoSQLite – simple key => value store based on SQLite3

## Introduction

NoSQLite is simple key-value store using SQLite as raw data store. Mainly for small project where MySQL is too heavy and files are too ugly.

version 0.1.2

## Requirements

- PHP >=5.3
    - PDO (by default as of PHP 5.1.0)
    - PDO_SQLITE (by default as of PHP 5.1.0)

## How to use

1. Create collection manager (file will be created if not exists)

        $nsql = new NoSQLite\NoSQLite('mydb.sqlite');

2. Get collection

        $collection = $nsql->getCollection('movies');

3. Set value in collection (key and value max length are [limited by SQLite TEXT datatype](http://sqlite.org/limits.html#max_length))

        $collection->set(uniqid(), json_encode(array('title' => 'Good Will Hunting', 'director' => 'Gus Van Sant'));

4. Get value from collection (will be created if not exists)

        $collection->get('3452345');

5.  Get all values

        $collection->getAll();

6. Delete all values

        $collection->deleteAll();

# License

(The MIT License)

Copyright (c) 2011 Maciej Winnicki <http://maciejwinnicki.pl/>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.