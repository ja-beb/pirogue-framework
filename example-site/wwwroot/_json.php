<?php
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

define('_BASE_URI', 'C:\\inetpub\example-site');

// Load & intialize pirogue framework:
require_once sprintf('%s\include\pirogue\import.inc', _BASE_URI);
__import(sprintf('%s\include', _BASE_URI));

// Import required libraries
import('pirogue/http_status');
import('pirogue/dispatcher');
import('pirogue/error_handler');
import('pirogue/database_collection');

set_error_handler('pirogue\_error_handler');

$GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;
$GLOBALS['._pirogue.dispatcher.controller_path'] = sprintf('%s\controllers\json', _BASE_URI);


// Possible "engines":
// Load file only - file uses "return" to return data or ob_start is returned. Allows for n-level orginazation that directly reflects file system
// Easiest pattern, uses just do require( '_json/%s', $path);
// Does not allow path based variables.


// route_register(string $pattern, function);
// can use string match, regex or sscanf() functions. fastest and best for small amount of routes


// Call function -> parse to {module file}/{function}
// Defined routes -> Use either regex or normal string paths

try {
    /* Initialize */
    __database_collection(realpath('_config'));

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    $_parts = explode('/', $_request_path);
    $_exec_app = array_shift($_parts);

    $_exe_controller = sprintf('%s\%s.inc', $GLOBALS['._pirogue.dispatcher.controller_path'], $_exec_app);
    if (file_exists($_exe_controller)) {
        require $_exe_controller;
        $_exe_function = sprintf( '%s_%s', $_SERVER['REQUEST_METHOD'], (0 == count($_parts)) ? 'index' : array_shift($_parts));
        if (function_exists($_exe_function)) {            
            $_exe_path = implode('/', $_parts);            
        } else {
            require sprintf('%s\_site_errors.inc', $GLOBALS['._pirogue.dispatcher.controller_path']);
            $_exe_method = 'route';
            $_exe_path = '404';
        }
    } else {
        require sprintf('%s\_site_errors.inc', $GLOBALS['._pirogue.dispatcher.controller_path']);
        $_exe_method = 'route';
        $_exe_path = '404';
    }

    /* process request */
    try {
        // $_results = function_exists($_func) ? call_user_func($_func, implode('/', $_parts), $request_data, $form_data) : _json_not_found('page', $route);
        
        // if method function does not exists but base function exists throw 405

        $_results = function_exists($_func) ? call_user_func($_func, implode('/', $_parts), $request_data, $form_data) : _json_not_found('page', $route);

        if (file_exists($_file)) {
            require $_file;
            $_func = sprintf('%s\%s_%s', $_module, $method, str_replace('-', '_', array_shift($_parts)));
            $_results = function_exists($_func) ? call_user_func($_func, implode('/', $_parts), $request_data, $form_data) : _json_not_found('page', $route);
        } else {
            $_results = _json_not_found('module', $route);
        }
    } catch (Exception $_exception) {
        $_results = _json_error($_exception);
    } catch (Error $_exception) {
        $_results = _json_error($_exception);
    }

    /* Route request and send results to client */
    return _dispatcher_send(_json_route($_SERVER['REQUEST_METHOD'], $_request_path, $_request_data, ('POST' == $_SERVER['REQUEST_METHOD']) ? $_POST : []));
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

// Failsafe errors:
http_response_code(500);
if ($GLOBALS['._pirogue.dispatcher.failsafe_exception']) {
    echo json_encode(sprintf('%s: (%s:%d)', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getMessage(), str_replace(_BASE_URI, '', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getFile()), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getLine()));
} else {
    echo json_encode('Unknown exception encountered');
}
