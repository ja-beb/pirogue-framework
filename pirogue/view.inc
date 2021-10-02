<?php
/**
 * Library for handling view content.
 * php version 8.0.0
 * 
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @category
 * @package
 * @license
 * @version
 * @link
 */

/**
 * View base folder.
 *
 * @var string $GLOBALS['._pirogue.view.path']
 */
$GLOBALS['._pirogue.view.path'] = '';

/**
 * initialize view library.
 * 
 * @param string $path The base location of the site's views.
 */
function __view(string $path): void
{
    $GLOBALS['._pirogue.view.path'] = $path;
}

/**
 * Get view file.
 * @param string $file View file name relative to view base directory.
 * @return string Path to the view file.
 */
function _view_get_path(string $file): ?string
{
    $view_file = implode(DIRECTORY_SEPARATOR, [$GLOBALS['._pirogue.view.path'], $file]);
    return file_exists($view_file) ? $view_file : null;
}

