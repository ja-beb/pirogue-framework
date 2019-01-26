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
 * @var string $GLOBALS['._pirogue.import.import_path']
 */
$GLOBALS['._pirogue.import.import_path'] = '';

/**
 * Library file extension.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.import.file_extension']
 */
$GLOBALS['._pirogue.import.file_exteions'] = '';

/**
 * Setup import library - needed before import function can be called.
 *
 * @param string $path
 *            Base path that contains library files.
 *            
 * @param string $file_extension
 *            The file extension for library files.
 */
function __import(string $path, string $file_extension = 'inc')
{
    $GLOBALS['._pirogue.import.import_path'] = $path;
    $GLOBALS['._pirogue.import.file_extension'] = $file_extension;
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
    $file = sprintf("%s\%s.%s", $GLOBALS['._pirogue.import.import_path'], $name, $GLOBALS['._pirogue.import.file_extension']);
    if (false == file_exists($file)) {
        throw new ErrorException("Unable to find library: {$name}");
    }
    include_once $file;
}



