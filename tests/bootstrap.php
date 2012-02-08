<?php

spl_autoload_register(function($class)
{
    if (0 === strpos($class, 'NoSQLite\\Test\\')) {
        $file = __DIR__ . '/../tests/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    } elseif (0 === strpos($class, 'NoSQLite\\')) {
        $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
});
