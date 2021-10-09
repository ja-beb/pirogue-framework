<?php

/**
 * Library for handling view content.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 * The base directory used to create view's file path.
 *
 * @internal use by libary only.
 * @var string $GLOBALS['._pirogue.view.path']
 */
$GLOBALS['._pirogue.view.path'] = '';

/**
 * The view file's extension.
 *
 * @internal use by library only.
 * @var string $GLOBALS['._pirogue.view.extension']
 */
$GLOBALS['._pirogue.view.extension'] = '';

/**
 * initialize view library.
 *
 * @uses $GLOBALS['._pirogue.view.extension']
 * @uses $GLOBALS['._pirogue.view.path']
 * @param string $path the base location of the site's views.
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
 * Translate view name to the respective view file.
 *
 * @internal use by dispatcher only.
 * @uses $GLOBALS['._pirogue.view.extension']
 * @uses $GLOBALS['._pirogue.view.path']
 * @param string $file the name of the desired view file relative to the base view directory.
 * @return string the absolute filename of the view file if found or an empty string if not found.
 */
function _pirogue_view_get_path(string $file): ?string
{
    $view_file = sprintf(
        '%s.%s',
        implode(DIRECTORY_SEPARATOR, [$GLOBALS['._pirogue.view.path'], $file]),
        $GLOBALS['._pirogue.view.extension']
    );
    return file_exists($view_file) ? $view_file : null;
}
