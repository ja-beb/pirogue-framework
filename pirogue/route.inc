<?php
/**
 * Routing functions for both file based and function based routes.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

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
function _route_parse(string $base, string $path): array
{
    $_path_exec = explode('/', $path);
    return [
        'file' => _route_get_file($base, array_slice($_path_exec, 0, 2)),
        'path' => implode('/', array_slice($_path_exec, 2))
    ];
}
