<?php

/**
 * Library for handling view content.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * view file format.
 * the format to use to load the view - including file extension.
 *
 * @internal use by libary only.
 * @var string $GLOBALS['._pirogue.view.format']
 */
$GLOBALS['._pirogue.view.format'] = '';

/**
 * initialize view library.
 *
 * @uses $GLOBALS['._pirogue.view.extension']
 * @uses $GLOBALS['._pirogue.view.path']
 * @param string $format A sprintf() format string for file name and path.
 */
function view_init(string $format): void
{
    $GLOBALS['._pirogue.view.format'] = $format;
}

/**
 * translate view name to the respective view file.
 * responsible for translating the views name to the file to load. Does not verify
 * that the view is in the view folder (ie ../ is passed to it).
 *
 * @uses $GLOBALS['._pirogue.view.extension']
 * @uses $GLOBALS['._pirogue.view.path']
 * @param string $file the name of the desired view file relative to the base view directory.
 * @return string the absolute filename of the view file if found or an empty string if not found.
 */
function view_get_path(string $file): ?string
{
    $view = sprintf($GLOBALS['._pirogue.view.format'], $file);
    return file_exists($view) ? $view : null;
}
