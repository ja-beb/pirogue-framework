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
 * @var string $GLOBALS['._sprout.import.path']
 */
$GLOBALS['._sprout.import.path'] = '';

/**
 * Library file extension.
 *
 * @internal
 * @var string $GLOBALS['._sprout.import.file_extension']
 */
$GLOBALS['._sprout.import.file_extension'] = '';

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
    $GLOBALS['._sprout.import.path'] = $path;
    $GLOBALS['._sprout.import.file_extension'] = $file_extension;
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
    $file_name = sprintf('%s.%s', $name, $GLOBALS['._sprout.import.file_extension']);
    $include_file = implode(DIRECTORY_SEPARATOR, [
        $GLOBALS['._sprout.import.path'],
        $file_name
    ]);
    if (false == file_exists($include_file)) {
        throw new ErrorException("Unable to find library: {$name}");
    }
    include_once $include_file;
}



