<?php 

use function pirogue\database_collection_open;
use function pirogue\error_handler;
use function pirogue\dispatcher_send;
use function pirogue\__database_collection;
use function pirogue\dispatcher_set_cache_control;

/**
 * Main dispatcher for HTML content.
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */

// Declare base folders:
define('_BASE_PATH', __DIR__);
define('_BASE_PATH_CONTROLLER', sprintf('%s\_html', _BASE_PATH));

// Load & intialize pirogue framework:
require '_include/pirogue/import.inc';
__import(sprintf('%s\_include', _BASE_PATH));

// Import required libraries
import('pirogue/dispatcher');
import('pirogue/error_handler');
import('pirogue/html_view');
import('pirogue/database_collection');

set_error_handler('pirogue\error_handler');

/**
 * Send html error message to user.
 *
 * @param
 *            ErrorException | Error $exception
 * @return string
 */
function _html_error($exception): string
{
    http_response_code(500);
    error_handler_log(database_collection_open('website'), $exception->getMessage(), $exception->getFile(), $exception->getLine());
    return $exception->getMessage();
}

/**
 * Request not found (404).
 * string $path Requested resource.
 *
 * @return string
 */
function _request_not_found(string $path): string
{
    http_response_code(404);
    dispatcher_set_cache_control(CACHE_CONTROL_TYPE_PRIVATE, - 1);
    return "Unable to find requested module: '{$path}.";
}

/**
 * Routes incoming request and return results.
 *
 * @param string $method
 * @param string $route
 * @param array $request_data
 * @param array $form_data
 * @return string
 */
function _request_route(string $method, string $route, array $request_data, array $form_data): string
{
    try {
        $_parts = explode('/', $route);
        $_module = array_shift($_parts);
        
        $_file = "_html/{$_module}.inc";
        if (file_exists($_file)) {
            require $_file;
            $_func = sprintf('%s\%s_%s', $_module, $method, array_shift($_parts));
            $_results = function_exists($_func) ? call_user_func($_func, implode('/', $_parts), $request_data, $form_data) : _request_not_found($route);
        } else {
            $_results = _request_not_found($route);
        }
    } catch (Exception $_exception) {
        $_results = _html_error($_exception);
    } catch (Error $_exception) {
        $_results = _html_error($_exception);
    }
    
    return $_results;
}

/* Initialize */
__database_collection(realpath('_config'));

/* Parse request */
$_request_data = $_GET;
$_request_path = $_request_data['__execution_path'] ?? '';
unset($_request_data['__execution_path']);

/* Route request and send results to client */
dispatcher_send(_request_route($_SERVER['REQUEST_METHOD'], $_request_path, $_request_data, ('POST' == $_SERVER['REQUEST_METHOD']) ? $_POST : []));
