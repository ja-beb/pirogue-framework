<?php

/**
 * library for loading include files.
 *
 * php version 8.0.0
 *
 * @author  Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\import;

use ErrorException;

/**
 * the sprintf pattern used to build include file paths.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.import.path_pattern']
 */
$GLOBALS['._pirogue.import.path_pattern'] = '';

/**
 * initialize the import library.
 *
 * @uses $GLOBALS['._pirogue.import.path_pattern']
 * @param string $path_pattern the file path pattern used to build include file paths.
 */
function _init(string $path_pattern): void
{
    $GLOBALS['._pirogue.import.path_pattern'] = $path_pattern;
}

/**
 * cleanup library resources.
 *
 * @uses $GLOBALS['._pirogue.import.path_pattern']
 * @return void
 */
function _finalize(): void
{
    unset(
        $GLOBALS['._pirogue.import.path_pattern']
    );
}

/**
 * load an include file.
 *
 * @uses $GLOBALS['._pirogue.import.path_pattern']
 *
 * @throws ErrorException the error thrown if the requested library file is not found.
 * @param string $name the name of library being loaded (translates to the filename without extension).
 */
function import(string $name): void
{
    $include_file = sprintf($GLOBALS['._pirogue.import.path_pattern'], $name);
    if (false == file_exists($include_file)) {
        throw new ErrorException(sprintf('Unable to find library: %s (%s).', $name, $include_file));
    }
    require_once $include_file;
}
