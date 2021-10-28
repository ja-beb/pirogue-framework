<?php

/**
 * library used to get controller's location files.
 *
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * controller file format.
 *
 * @var string $GLOBALS['._pirogue.controller_import.controller_format']
 */
$GLOBALS['._pirogue.controller_import.controller_format'] = '';


/**
 * initialize site route library.
 *
 * @uses $GLOBALS['._pirogue.controller_import.controller_format']
 * @param string $controller_format
 * @return void
 */
function controller_import_init(string $controller_format)
{
    $GLOBALS['._pirogue.controller_import.controller_format'] = $controller_format;
}

/**
 * map a controller file to full file path.
 *
 * @uses $GLOBALS['._pirogue.controller_import.controller_format']
 * @param array $path
 */
function controller_import_get_controller(array $path): string
{
    if (empty($path)) {
        return '';
    } else {
        $file = sprintf($GLOBALS['._pirogue.controller_import.controller_format'], implode(DIRECTORY_SEPARATOR, $path));
        return file_exists($file) ? $file : controller_import_get_controller(array_slice($path, 0, count($path) - 1));
    }
}
