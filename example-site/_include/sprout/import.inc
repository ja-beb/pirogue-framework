<?php

/**
 * Site notifications
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

namespace sprout;

use ErrorException;

/**
 * Base folder for library import. 
 * @internal
 * @var string $GLOBALS['._sprout.index.import_path']
 */
$GLOBALS['._sprout.index.import_path'] = '';

/**
 * setup import library.
 * @param string $path
 */
function __import(string $path)
{
    $GLOBALS['._sprout.index.import_path'] = $path;
}

/**
 * Import library file.
 * @param string $lib
 * @throws ErrorException
 */
function import(string $name)
{
    $file = sprintf("%s\%s.inc", $GLOBALS['._sprout.index.import_path'], $name);
    if (false == file_exists($file)) {
        throw new ErrorException("Unable to find library: {$name}");
    }
    include_once $file;
}



