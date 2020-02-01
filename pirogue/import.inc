<?php

/**
 * Import library files.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 * Base folder for library import.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.import.path']
 */
$GLOBALS['._pirogue.import.path'] = '';

/**
 * Setup import library - needed before import function can be called.
 *
 * @param string $path
 *            Base path that contains library files.
 *            
 * @param string $file_extension
 *            The file extension for library files.
 */
function import_init(string $path)
{
    $GLOBALS['._pirogue.import.path'] = $path;
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
    $include_file = sprintf('%s\%s.inc', $GLOBALS['._pirogue.import.path'], $name);
    if (false == file_exists($include_file)) {
        throw new ErrorException("Unable to find library: {$name}");
    }
    include_once $include_file;
}



