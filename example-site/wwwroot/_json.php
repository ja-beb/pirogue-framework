<?php


$GLOBALS['._json.dispatcher.start_time'] = microtime(true);

use function pirogue\__database_collection;
use function pirogue\__import;
use function pirogue\_dispatcher_send;
use function pirogue\_route_clean;
use function pirogue\_route_parse_flat;
use function pirogue\_route_parse_function;
use function pirogue\import;


/**
 * Main dispatcher for JSON content.
 *
 * Processes user request and routes it to the proper function found the requested module file in _json/[ModuleName].inc - handles any REST method
 * that the developer writes end point for.
 *
 * @example For any REST method:
 *          site.url/module/function/function_data.json?data=my_data
 *         
 *          include(_json/module.inc);
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

// Send request headers (type for this dispatcher):
header('Content-Type: application/json', true);

define('_BASE_FOLDER', 'C:\\inetpub\example-site');

// Load & intialize pirogue framework:
require_once sprintf('%s\include\pirogue\import.inc', _BASE_FOLDER);
__import(sprintf('%s\include', _BASE_FOLDER));

try {

    // Import base required libraries
    import('pirogue\dispatcher');
    import('pirogue\database_collection');
    import('pirogue\route');

    set_error_handler('pirogue\_dispatcher_error_handler');

    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;
    $GLOBALS['._pirogue.dispatcher.controller_path'] = sprintf('%s\controllers\json', _BASE_FOLDER);

    /* Initialize libraries: */
    __database_collection(sprintf('%s\config', _BASE_FOLDER));

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Route path to controller file, function & path:
    $_exec_data = $_request_data;
    

    // execute 100 times:
    $start = microtime(true);
    for ($i = 0; $i < 1000; $i ++) {
        _route_parse_function($GLOBALS['._pirogue.dispatcher.controller_path'], $_request_path);
    }
    print_r((microtime(true) - $start) * 100000);
    echo "\n";
    echo "\n";

    $start = microtime(true);
    for ($i = 0; $i < 1000; $i ++) {
        _route_parse_flat($GLOBALS['._pirogue.dispatcher.controller_path'], $_request_path);
    }
    print_r((microtime(true) - $start) * 100000);
    echo "\n";
    echo "\n";
    return 
    $_path = explode('/', $_request_path);
    $_route_base = sprintf('%s\%s', _route_clean($_path[0] ?? ''), _route_clean($_path[1] ?? ''));

    $_exec_file = "{$GLOBALS['._pirogue.dispatcher.controller_path']}\\{$_route_base}.inc";
    $_exec_function = '';
    if (false == file_exists($_exec_file)) {
        $_exec_file = '';
    } else {
        require $_exec_file;
        $_exec_function = sprintf('controllers\json\%s\route_%s', $_route_base, _route_clean($_path[2] ?? ''));
        if (false == function_exists($_exec_function)) {
            $_exec_function = '';
        } else {
            $_exec_path = implode('/', array_slice($_path, 3));
        }
    }

    if ('' == $_exec_function) {
        require "{$GLOBALS['._pirogue.dispatcher.controller_path']}\_site_errors.inc";
        $_route_base = 'site_errors';
        $_exec_function = 'controllers\_site_errors\route_error_404';
        $_exec_data = [
            'request_path' => $_request_path,
            'request_data' => $_request_data
        ];
    }

    echo json_encode([
        $_exec_file,
        $_exec_function,
        $_exec_path,
        $_exec_data
    ]);

    header('X-Powered-By: pirogue php');
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._json.dispatcher.start_time']) * 1000));
    exit();

    /* process request */
    try {
        $_json_data = call_user_func($_exec_function, $_exec_path, $_exec_data, ('POST' == $_SERVER['REQUEST_METHOD']) ? $_POST : []);
    } catch (Exception $_exception) {
        require (implode(DIRECTORY_SEPARATOR, [
            $GLOBALS['._pirogue.dispatcher.controller_path'],
            '_site_errors.inc'
        ]));
        $_json_data = controllers\_site_errors\route('500', [
            $_exception->getMessage()
        ]);
    } catch (Error $_exception) {
        require (implode(DIRECTORY_SEPARATOR, [
            $GLOBALS['._pirogue.dispatcher.controller_path'],
            '_site_errors.inc'
        ]));
        $_json_data = controllers\_site_errors\route('500', [
            $_exception->getMessage()
        ]);
    }
    return _dispatcher_send(json_encode($_json_data));
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

// Failsafe errors:
http_response_code(500);
if ($GLOBALS['._pirogue.dispatcher.failsafe_exception']) {
    echo json_encode(sprintf('%s: (%s:%d)', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getMessage(), str_replace(_BASE_FOLDER, '', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getFile()), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getLine()));
} else {
    echo json_encode('Unknown exception encountered');
}






