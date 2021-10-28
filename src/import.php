<?php

/**
 * Import library files.
 *
 * php version 8.0.0
 *
 * @author  Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

use ErrorException;
use InvalidArgumentException;

/**
 * Base folder for library import.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.import.path']
 */
$GLOBALS['._pirogue.import.path'] = '';

/**
 * Initialize the import library.
 *
 * @uses $GLOBALS['._pirogue.import.path']
 * @param string $path the base path that contains *.php library files files.
 */
function import_init(string $path): void
{
    if (!is_dir($path)) {
        throw new InvalidArgumentException(sprintf('Directory does not exist: "%s"', $path));
    }
    $GLOBALS['._pirogue.import.path'] = $path;
}

/**
 * Import library file.
 *
 * @uses $GLOBALS['._pirogue.import.path']
 * @throws ErrorException the error thrown if the requested library file is not found.
 * @param string $name the name of library being loaded (translates to the filename without extension).
 */
function import_load(string $name): void
{
    $include_file = sprintf('%s.php', implode(DIRECTORY_SEPARATOR, [ $GLOBALS['._pirogue.import.path'], $name]));
    if (false == file_exists($include_file)) {
        throw new ErrorException(sprintf('Unable to find library: %s (%s).', $name, $include_file));
    }
    include_once $include_file;
}
