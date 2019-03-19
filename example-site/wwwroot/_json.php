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

define('_BASE_FOLDER', 'C:\\inetpub\example-site');

// Load & intialize pirogue framework:
require_once sprintf('%s\include\pirogue\import.inc', _BASE_FOLDER);
__import(sprintf('%s\include', _BASE_FOLDER));

// Import base required libraries
import('pirogue\http_status');
import('pirogue\dispatcher');
import('pirogue\database_collection');

set_error_handler('pirogue\_dispatcher_error_handler');

$GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;
$GLOBALS['._pirogue.dispatcher.controller_path'] = sprintf('%s\controllers\json', _BASE_FOLDER);

try {
    /* Initialize libraries: */
    __database_collection(sprintf('%s\config', _BASE_FOLDER));

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Route path to controller file, function & path:
    $_exec_data = $_request_data;
    $_parts = explode('/', $_request_path);

    // Get app file name:
    $_exec_app = $GLOBALS['._pirogue.dispatcher.controller_path'];
    $_exec_function = 'controllers';
    while (0 < count($_parts)) {
        $_current = array_shift($_parts);
        $_exec_function = sprintf('%s\%s', $_exec_function, $_current);
        $_exec_app = implode(DIRECTORY_SEPARATOR, [
            $_exec_app,
            $_current
        ]);

        if (file_exists("{$_exec_app}.inc")) {
            $_exec_app = "{$_exec_app}.inc";
            break;
        } elseif (false == is_dir($_exec_app)) {
            $_exec_function = '';
            $_exec_app = null;
            $_parts = [];
        }
    }

    // get controller function:
    if ('' != $_exec_function) {
        require ($_exec_app);
        $_exec_function = sprintf('%s\%s_%s', $_exec_function, strtolower($_SERVER['REQUEST_METHOD']), (0 == count($_parts)) ? 'index' : array_shift($_parts));
        if (false == function_exists($_exec_function)) {
            $_exec_function = '';
        }
    }

    // Check for 404 error:
    if ('' == $_exec_function) {
        $_exec_app = implode(DIRECTORY_SEPARATOR, [
            $GLOBALS['._pirogue.dispatcher.controller_path'],
            '_site_errors.inc'
        ]);
        require ($_exec_app);
        $_exec_function = 'controllers\_site_errors\route';
        $_exec_path = '404';
        $_exec_data = [
            'request_path' => $_request_path,
            'request_data' => $_request_data
        ];
    } else {
        $_exec_path = implode('/', $_parts);
    }

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






