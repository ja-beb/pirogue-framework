<?php
$GLOBALS['._json.dispatcher.start_time'] = microtime(true);

use function pirogue\__database_collection;
use function pirogue\__import;
use function pirogue\_dispatcher_send;
use function pirogue\_route_clean;
use function pirogue\_route_parse_flat;
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



function _route_execute(string $file, string $path, array $data): array{
    if ( file_exists($file) )
    {
        ob_start();
        $GLOBALS['.pirogue.view.data'] = $data;
        $GLOBALS['.pirogue.view.path'] = $path;
        $_json_data = require $file;
        ob_get_clean();
        
        return is_array($_json_data) ? $_json_data : [$_json_data];
    }
    throw new ErrorException(sprintf("Unable to find requested resource '$file'."));
}


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
    $GLOBALS['._pirogue.dispatcher.controller_path'] = sprintf('%s\view\json', _BASE_FOLDER);

    /* Initialize libraries: */
    __database_collection(sprintf('%s\config', _BASE_FOLDER));

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Route path to controller file, function & path:
    $_exec_data = $_request_data;

    $_exec_path = _route_clean($_request_path);
    $_route = _route_parse_flat($GLOBALS['._pirogue.dispatcher.controller_path'], $_exec_path);
    if (false == file_exists($_route['file'])) {
        $_route = _route_parse_flat($GLOBALS['._pirogue.dispatcher.controller_path'], '_error/404');
        $_exec_data = [$_request_path, $_request_data];
    }

    
    
    /* process request */
    try {
        
        ob_start();;
        $_json_data = _route_execute($_route['file'], $_route['path'], $_exec_data);
        ob_clean();
    
        
        header('Content-Type: application/json');        
        header('X-Powered-By: pirogue php');
        header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._json.dispatcher.start_time']) * 1000));

    } catch (Exception $_exception) {
        $_route = _route_parse_flat($GLOBALS['._pirogue.dispatcher.controller_path'], '_error/500');
        $_json_data = _route_execute($_route['file'], '', [$_request_path, $_request_data, $_exception->getMessage()]);
    } catch (Error $_exception) {
        $_route = _route_parse_flat($GLOBALS['._pirogue.dispatcher.controller_path'], '_error/500');
        $_json_data = _route_execute($_route['file'], '', [$_request_path, $_request_data, $_exception->getMessage()]);
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






