<?php
/**
 * Routing functions for both file based and function based routes.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

/**
 * Remove and preceding underscores from the path element. 
 * @param string $value
 * @return array
 */
function _route_clean(string $value): array
{
    return '' == $value ? [] : explode('/', preg_replace(['/^(_+)/', '/(\/_+)/'], ['','/'], $value));
}

/*
 * fastest & simplest (1x)
 * Simply loads a flat file that will return data.
 */
function _route_parse_flat(string $base, string $path): array
{
    $_exec_path = _route_clean($path);
    return [
        'file' => sprintf('%s\%s\%s.inc', $base, $_exec_path[0] ?? '', $_exec_path[1] ?? ''),
        'path' => implode('/', array_slice($_exec_path, 2))
    ];
}

/*
 * fast (2x)
 */
function _route_parse_function(string $base, string $path): array
{
    $_exec_path = _route_clean($path);
    return [
        'file' => sprintf('%s\%s\%s.inc', $base, $_exec_path[0] ?? '', $_exec_path[1] ?? ''),
        'function' => sprintf('controllers\%s', $_exec_path[2] ?? ''),
        'path' => implode('/', array_slice($_exec_path, 3))
    ];
}
