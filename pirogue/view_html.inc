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

$GLOBALS['.pirogue.view.body.id'] = '';
$GLOBALS['.pirogue.view.body.class'] = '';
$GLOBALS['.pirogue.view.style.files'] = [];
$GLOBALS['.pirogue.view.style.inline'] = '';
$GLOBALS['.pirogue.view.script.files'] = [];
$GLOBALS['.pirogue.view.script.inline'] = '';

$GLOBALS['.pirogue.view.menu'] = '';
$GLOBALS['.pirogue.view.application.title'] = '';
$GLOBALS['.pirogue.view.application.url'] = '';

function _view_html_load(string $file, string $path, array $data): string
{
    if (file_exists($file)) {
        ob_start();
        $GLOBALS['.pirogue.view.data'] = $data;
        $GLOBALS['.pirogue.view.path'] = $path;
        require $file;
        $_content = ob_get_clean();

        
        if (false == empty($GLOBALS['.pirogue.view.template'])) {}

        // check for application menu.
        
        return $_content;
    }
    throw new ErrorException(sprintf("Unable to find requested resource '$file'."));
}

function _view_html_route_error($exception, string $path, array $data): string
{
    http_response_code(500);
    $_route = _route_parse('_site-errors/500');
    return _view_html_load($_route['file'], $_route['path'], [
        'path' => $path,
        'data' => $data,
        'exception' => $exception
    ]);
}


function _view_html_route_access_denied($exception, string $path, array $data): string
{
    http_response_code(403);
    $_route = _route_parse('_site-errors/403');
    return _view_html_load($_route['file'], $_route['path'], [
        'path' => $path,
        'data' => $data,
        'exception' => $exception
    ]);
}