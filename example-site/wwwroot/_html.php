<?php
$GLOBALS['._html.dispatcher.start_time'] = microtime(true);

use function pirogue\__database_collection;
use function pirogue\__import;
use function pirogue\_dispatcher_send;
use function pirogue\import;

/**
 * Main dispatcher for HTML content.
 *
 * Processes user request and routes it to the proper function found the requested module file in _html/[ModuleName].inc - handles any REST method
 * that the developer writes end point for.
 *
 * @example For any REST method:
 *          site.url/module/function/function_data.html?data=my_data
 *         
 *          include(_html/module.inc);
 *         
 *          For GET REQUEST: module/GET_function(function_data, request_data);
 *          For POST REQUEST: module/POST_function(function_data, request_data, post_data);
 *          For PUT REQUEST: module/PUT_function(function_data, request_data, post_data);
 *          For DELETE REQUEST: module/DELETE_function(function_data, request_data);
 *          For OPTIONS REQUEST: module/DELETE_function(function_data, request_data);
 *         
 *         
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */

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

/*
 * fastest & simplest (1x)
 * Simply loads a flat file that will return data.
 */
function _route_parse(string $base, string $path): array
{
    $_path_exec = explode('/', $path);
    return [
        'file' => sprintf('%s.phtml', implode(DIRECTORY_SEPARATOR, array_merge([$base], array_slice($_path_exec, 0, 2)))),
        'path' => implode('/', array_slice($_path_exec, 2))
    ];
}

function _route_execute(string $file, string $path, array $data): string
{
    if (file_exists($file)) {
        ob_start();
        $GLOBALS['.pirogue.view.data'] = $data;
        $GLOBALS['.pirogue.view.path'] = $path;
        require $file;
        $_html_content = ob_get_clean();

        return $_html_content;
    }
    throw new ErrorException(sprintf("Unable to find requested resource '$file'."));
}

define('_BASE_FOLDER', 'C:\\inetpub\example-site');

// Load & intialize pirogue framework:
require_once sprintf('%s\include\pirogue\import.inc', _BASE_FOLDER);
__import(sprintf('%s\include', _BASE_FOLDER));

try {

    // Import base required libraries
    import('pirogue\dispatcher');
    import('pirogue\database_collection');

    set_error_handler('pirogue\_dispatcher_error_handler');

    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;
    $GLOBALS['._pirogue.dispatcher.controller_path'] = sprintf('%s\view\html', _BASE_FOLDER);

    /* Initialize libraries: */
    __database_collection(sprintf('%s\config', _BASE_FOLDER));

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Route path to controller file, function & path:
    $_exec_data = $_request_data;

    $_exec_path = _route_clean($_request_path);
    $_route = _route_parse($GLOBALS['._pirogue.dispatcher.controller_path'], $_exec_path);
    $_html_content = '';

    if (false == file_exists($_route['file'])) {
        $_route = _route_parse($GLOBALS['._pirogue.dispatcher.controller_path'], '_error/404');
        $_exec_data = [$_request_path, $_request_data];
    }

    /* process request */
    try {
        ob_start();
        $_html_content = _route_execute($_route['file'], $_route['path'], $_exec_data);
        ob_clean();
    } catch (Exception $_exception) {
        http_response_code(500);
        $_html_content = sprintf('%s - %s (%d).', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine());
    } catch (Error $_exception) {
        http_response_code(500);
        $_html_content = sprintf('%s - %s (%d).', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine());
    }

    header('Content-Type: text/html');
    header('X-Powered-By: pirogue php');
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._html.dispatcher.start_time']) * 1000));
    return _dispatcher_send($_html_content);
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

// Failsafe errors:
header('Content-Type: text/html');
header('X-Powered-By: pirogue php');
header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._html.dispatcher.start_time']) * 1000));
http_response_code(500);

if ($GLOBALS['._pirogue.dispatcher.failsafe_exception']) {
    printf('ERROR %s: (%s:%d)', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getMessage(), str_replace(_BASE_FOLDER, '', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getFile()), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getLine());
} else {
    echo 'Unknown exception encountered';
}






