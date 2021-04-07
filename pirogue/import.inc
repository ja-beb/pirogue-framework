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
 * Initialize the import library.
 *
 * @param string $path Base path that contains PHP *.inc files.
 */
function __import(string $path): void
{
    $GLOBALS['._pirogue.import.path'] = $path;
}

/**
 * Import library file.
 *
 * @throws ErrorException Error thrown if the requested library file is not found.
 * 
 * @param string $name Name of library being loaded (translates to the filename without extension).
 */
function import(string $name): void
{
    $include_file = sprintf('%s\%s.inc', $GLOBALS['._pirogue.import.path'], $name);
    if (false == file_exists($include_file)) {
        throw new ErrorException("Unable to find library: {$name}");
    }
    include_once $include_file;
}