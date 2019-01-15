<?php
use function sprout\__import;
use function sprout\import;
use function sprout\database_collection_open;
use function sprout\error_handler;
<<<<<<< HEAD
use function sprout\_dispatcher_send;
=======
use function sprout\dispatcher_send;
>>>>>>> f7322eefdd80c3f247c0b68b63abcd8270cb55a2
use function sprout\__database_collection;
use function sprout\dispatcher_set_cache_control;

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

// Declare base folders:
define('_BASE_PATH', __DIR__);
define('_BASE_PATH_CONTROLLER', sprintf('%s\_json', _BASE_PATH));

// Load & intialize sprout framework:
require '_include/sprout/import.inc';
__import(sprintf('%s\_include', _BASE_PATH));

// Import required libraries
import('sprout/dispatcher');
import('sprout/error_handler');
import('sprout/database_collection');

set_error_handler(function (string $message, string $file, int $line) {
    error_handler($message, $file, $line);
});

/**
 * Send json error message to user.
 *
 * @param
 *            ErrorException | Error $exception
 * @return string
 */
function _json_error($exception): string
{
    http_response_code(500);
    error_handler_log(database_collection_open('website'), $exception->getMessage(), $exception->getFile(), $exception->getLine());
    return $exception->getMessage();
}

/**
 * JSON request not found (404).
 * string $path Requested resource.
 *
 * @return string
 */
function _json_not_found(string $path): string
{
    http_response_code(404);
    dispatcher_set_cache_control(CACHE_CONTROL_DISABLED);
    return "Unable to find requested module: '{$path}.";
}

/**
 * Routes incoming request and return json encoded results.
 *
 * @param string $method
 * @param string $route
 * @param array $request_data
 * @param array $form_data
 * @return string
 */
function _json_route(string $method, string $route, array $request_data, array $form_data): string
{
    try {
        $_parts = explode('/', $route);
        $_module = array_shift($_parts);

        $_file = "_json/{$_module}.inc";
        if (file_exists($_file)) {
            require $_file;
            $_func = sprintf('%s\%s_%s', $_module, $method, array_shift($_parts));
            $_results = function_exists($_func) ? call_user_func($_func, implode('/', $_parts), $request_data, $form_data) : _json_not_found($route);
        } else {
            $_results = _json_not_found($route);
        }
    } catch (Exception $_exception) {
        $_results = _json_error($_exception);
    } catch (Error $_exception) {
        $_results = _json_error($_exception);
    }

    return json_encode($_results);
}

/* Initialize */
__database_collection(realpath('_config'));

/* Parse request */
$_request_data = $_GET;
$_request_path = $_request_data['__execution_path'] ?? '';
unset($_request_data['__execution_path']);

/* Route request and send results to client */
_dispatcher_send(_json_route($_SERVER['REQUEST_METHOD'], $_request_path, $_request_data, ('POST' == $_SERVER['REQUEST_METHOD']) ? $_POST : []));
