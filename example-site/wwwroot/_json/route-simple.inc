<?php
$GLOBALS['._json.dispatcher.start_time'] = microtime(true);
use function pirogue\__import;
use function pirogue\import;
use function pirogue\database_collection_open;
use function pirogue\_error_handler;
use function pirogue\_dispatcher_send;
use function pirogue\__database_collection;
use function pirogue\dispatcher_set_cache_control;
use function pirogue\_json_route;

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

    set_error_handler('pirogue\_dispatcher_error_handler');

    /* Initialize libraries: */
    __database_collection(sprintf('%s\config', _BASE_FOLDER));

    /* Parse request */
    $_exec_data = $_GET;
    $_request_path = $_exec_data['__execution_path'] ?? '';
    unset($_exec_data['__execution_path']);

    // Route path to controller file, function & path:
    $_path = explode('/', $_request_path);
    $_exec_file = sprintf('%s\controllers\json-simple\%s\%s.inc', _BASE_FOLDER, $_path[0] ?? 'default', $_path[1] ?? 'index');
    
    if (false == file_exists($_exec_file)) {
        $_exec_file = sprintf('%s\controllers\json-simple\_site_errors\404.inc', _BASE_FOLDER);
        $_exec_path = $_request_path;
    }else{
        $_exec_path = implode('/', array_slice($_path, 2));        
    }

    $_json_data = include($_exec_file);
    
    header ( 'X-Powered-By: pirogue php' );
    header(sprintf('X-Execute-Footprint: %0.04fmb', memory_get_usage () /1048576));    
    header(sprintf('X-Execute-Milliseconds: %f', ( microtime(true) - $GLOBALS['._json.dispatcher.start_time']) * 1000 ));
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






