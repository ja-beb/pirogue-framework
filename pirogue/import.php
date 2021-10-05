<?php

/**
 * Import library files.
 *
 * php version 8.0.0
 *
 * @author  Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

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
 * @param string $path Base path that contains PHP *.php files.
 * @return void
 */
function pirogue_import_init(string $path): void
{
    if (!is_dir($path)) {
        throw new InvalidArgumentException(sprintf('Directory does not exist: "%s"', $path));
    }
    $GLOBALS['._pirogue.import.path'] = $path;
}

/**
 * Import library file.
 *
 * @throws ErrorException Error thrown if the requested library file is not found.
 * @param string $name Name of library being loaded (translates to the filename without extension).
 * @return void
 */
function pirogue_import_load(string $name): void
{
    $include_file = sprintf('%s.php', implode(DIRECTORY_SEPARATOR, [ $GLOBALS['._pirogue.import.path'], $name]));
    if (false == file_exists($include_file)) {
        throw new ErrorException("Unable to find library: {$name} ({$include_file}).");
    }
    include_once $include_file;
}
