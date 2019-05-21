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
function _route_clean(string $value): string
{
    return ('' == $value) ? '' : preg_replace(['/^(_+)/', '/(\/_+)/'], ['','/'], $value);
}


function _route_get_file(string $base, array $path): string{
    return sprintf('%s.inc', implode(DIRECTORY_SEPARATOR, array_merge([$base], $path)));
}

/*
 * fastest & simplest (1x)
 * Simply loads a flat file that will return data.
 */
function _route_parse_flat(string $base, string $path): array
{
    $_path_exec = explode('/', $path);
    return [
        'file' => _route_get_file($base, array_slice($_path_exec,0,2)),
        'path' => implode('/', array_slice($_path_exec, 2))
    ];
}

/*
 * fast (2x)
 */
function _route_parse_function(string $base, string $path): array
{   
    $_path_exec = explode('/', $path);
    return [
        'file' => sprintf('%s\%s\%s.inc', $base, array_slice($_path_exec,0,2)),
        'function' => sprintf('controllers\%s', $_path_exec[2] ?? ''),
        'path' => implode('/', array_slice($_path_exec, 3))
    ];
}


