<?php

/**
 * Library for handling view content.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 * View base folder.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.view.path']
 */
$GLOBALS['._pirogue.view.path'] = '';

/**
 * View file extension.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.view.extension']
 */
$GLOBALS['._pirogue.view.extension'] = '';

/**
 * initialize view library.
 *
 * @param string $path The base location of the site's views.
 */
function pirogue_view_init(string $path, string $extension = 'phtml'): void
{
    if (!is_dir($path)) {
        throw new InvalidArgumentException(sprintf('Directory does not exist: "%s"', $path));
    }
    $GLOBALS['._pirogue.view.path'] = $path;
    $GLOBALS['._pirogue.view.extension'] = $extension;
}

/**
 * Get view file.
 *
 * @internal
 * @param string $file View file name relative to view base directory.
 * @return string Path to the view file.
 */
function _pirogue_view_get_path(string $file): ?string
{
    $view_file = sprintf( '%s.%s', implode(DIRECTORY_SEPARATOR, [$GLOBALS['._pirogue.view.path'], $file]), $GLOBALS['._pirogue.view.extension']);
    return file_exists($view_file) ? $view_file : null;
}
