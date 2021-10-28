<?php

/**
 * library for loading include files.
 *
 * php version 8.0.0
 *
 * @author  Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

use ErrorException;

/**
 * the sprintf pattern used to build include file paths.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.import.pattern']
 */
$GLOBALS['._pirogue.import.pattern'] = '';

/**
 * initialize the import library.
 *
 * @uses $GLOBALS['._pirogue.import.pattern']
 * @param string $pattern the file path pattern used to build include file paths.
 */
function import_init(string $path): void
{
    $GLOBALS['._pirogue.import.pattern'] = $path;
}

/**
 * load an include file.
 *
 * @uses $GLOBALS['._pirogue.import.pattern']
 *
 * @throws ErrorException the error thrown if the requested library file is not found.
 * @param string $name the name of library being loaded (translates to the filename without extension).
 */
function import_load(string $name): void
{
    $include_file = sprintf($GLOBALS['._pirogue.import.pattern'], $name);
    if (false == file_exists($include_file)) {
        throw new ErrorException(sprintf('Unable to find library: %s (%s).', $name, $include_file));
    }
    require_once $include_file;
}
