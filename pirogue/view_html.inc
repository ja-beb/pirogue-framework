<?php
/**
 * Primary html view library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;
$GLOBALS['.pirogue.view.data'] = [];
$GLOBALS['.pirogue.view.path'] = '';
$GLOBALS['.pirogue.view.template'] = '';

function _view_html_load(string $file, string $path, array $data): string
{
    if (file_exists($file)) {
        ob_start();
        $GLOBALS['.pirogue.view.data'] = $data;
        $GLOBALS['.pirogue.view.path'] = $path;
        $GLOBALS['.pirogue.view.template'] = '';
        require $file;
        $_content = ob_get_clean();

        if (false == empty($GLOBALS['.pirogue.view.template'])) {}

        return $_content;
    }
    throw new ErrorException(sprintf("Unable to find requested resource '$file'."));
}

function _view_html_route_error($exception, string $path, array $data): string
{
    http_response_code(500);
    $_route = _route_parse('_error-500');
    return _view_html_load($_route['file'], $_route['path'], [
        'path' => $path,
        'data' => $data,
        'exception' => $exception
    ]);
}