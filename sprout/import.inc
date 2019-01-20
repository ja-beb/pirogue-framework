<?php

/**
 * Import library files.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace sprout;

use ErrorException;



/**
 * Base folder for library import.
 *
 * @internal
 * @var string $GLOBALS['._sprout.index.import_path']
 */
$GLOBALS['._sprout.index.import_path'] = '';

/**
 * Setup import library - needed before import function can be called.
 *
 * @param string $path
 *            Base pat that contains library files.
 */
function __import(string $path)
{
    $GLOBALS['._sprout.index.import_path'] = $path;
}

/**
 * Import library file.
 *
 * @param string $name
 *            Name of library being loaded without file extension.
 * @throws ErrorException Error thrown if the requested library file is not found.
 */
function import(string $name)
{
    $file = sprintf("%s\%s.inc", $GLOBALS['._sprout.index.import_path'], $name);
    if (false == file_exists($file)) {
        throw new ErrorException("Unable to find library: {$name}");
    }
    include_once $file;
}



