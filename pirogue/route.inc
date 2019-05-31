<?php
/**
 * Routing functions for both file based and function based routes.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

/**
 * File extension for loaded files.
 *
 * @var string $GLOBALS['._pirogue.route.file_extension']
 */
$GLOBALS['._pirogue.route.file_extension'] = '';

$GLOBALS['._pirogue.route.file_path'] = '';

/**
 * Initialize route library.
 *
 * @param string $file_extension
 *            file extension for loaded files.
 */
function __route(string $path, string $extension)
{
    $GLOBALS['._pirogue.route.file_path'] = $path;
    $GLOBALS['._pirogue.route.file_extension'] = $extension;
}

/**
 * Remove and preceding underscores from the path element.
 *
 * @param string $value
 * @return array
 */
function _route_clean(string $value): string
{
    return ('' == $value) ? '' : preg_replace([
        '/^(_+)/',
        '/(\/_+)/'
    ], [
        '',
        '/'
    ], $value);
}

/**
 * Parse user request into a path to load and the remaining path.
 *
 * @param string $base
 * @param string $path
 * @return array
 */
function _route_parse(string $path): array
{
    $_path_exec = explode('/', $path);
    return [
        'file' => sprintf('%s.%s', implode(DIRECTORY_SEPARATOR, array_merge([
            $GLOBALS['._pirogue.route.file_path']
        ], array_slice($_path_exec, 0, 2))), $GLOBALS['._pirogue.route.file_extension']),
        'path' => implode('/', array_slice($_path_exec, 2))
    ];
}
