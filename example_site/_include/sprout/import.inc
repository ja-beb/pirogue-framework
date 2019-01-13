<?php

/**
 * 
 */

/**
 *
 * @var string $GLOBALS['._import_path']
 */
$GLOBALS['._import_path'] = '';

/**
 *
 * @param string $path
 */
function __import(string $path)
{
    $GLOBALS['._import_path'] = $path;
}

/**
 *
 * @param string $lib
 * @throws RuntimeException
 */
function import(string $name)
{
    $file = sprintf("%s\%s.inc", $GLOBALS['._import_path'], $name);

    if (false == file_exists($file)) {
        throw new RuntimeException("Unable to find library: {$name}");
    }

    include_once $file;
}



