<?php
use function sprout\database_collection_open;

/**
 * Main dispatcher for JSON content.
 *
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */

// Send request headers (type for this dispatcher):
header('Content-Type: application/json', true);

// Load & intialize sprout framework:
require '_include/sprout/import.inc';
__import(realpath('_include'));

// Import required libraries
import('sprout/dispatcher');
import('sprout/error_handler');
import('sprout/json');
import('sprout/database_collection');

set_error_handler('sprout\error_handler');

/**
 * Send json error message to user.
 * @param ErrorException | Error $exception
 */
function _json_error($exception)
{
    http_response_code(500);
    sprout\error_handler_log(sprout\database_collection_open('website'), $exception->getMessage(), $exception->getFile(), $exception->getLine());
    sprout\dispatcher_send(json_encode($exception->getMessage()));
}


try {
    /* Initialize */
    sprout\__database_collection(realpath('_config'));

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);
    
    $_parts = explode('/', $_request_path);
    $_module = array_shift($_parts);

    $_file = "_json/{$_module}.inc";
    if (file_exists($_file)) {
        require "_json/{$_module}.inc";
        $_func = sprintf('%s\%s_%s', $_module, $_SERVER['REQUEST_METHOD'], array_shift($_parts));
        if (function_exists($_func)) {
            return sprout\dispatcher_send(json_encode($_func(implode('/', $_parts ), $_request_data, ('POST' == $_SERVER['REQUEST_METHOD']) ? $_POST : [])));
        }
    }
    
    http_response_code(404);
    sprout\dispatcher_set_cache_control(CACHE_CONTROL_TYPE_PRIVATE, - 1);
    return sprout\dispatcher_send(json_encode('Unable to find requested item.'));
} catch (Exception $_exception) {
    return _json_error($_exception);
} catch (Error $_exception) {
    return _json_error($_exception);
}