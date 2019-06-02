<?php


ob_start();
$GLOBALS['._html.dispatcher.start_time'] = microtime(true);

use function pirogue\__database_collection;
use function pirogue\__import;
use function pirogue\_dispatcher_send;
use function pirogue\import;
use function pirogue\_route_clean;
use function pirogue\_route_parse;
use function pirogue\__route;
use function pirogue\_view_html_load;
use function pirogue\__dispatcher;

define('_BASE_FOLDER', 'C:\\inetpub\example-site');

// Load & intialize pirogue framework:
require_once sprintf('%s\include\pirogue\import.inc', _BASE_FOLDER);
__import(sprintf('%s\include', _BASE_FOLDER));

try {

    // Import base required libraries
    import('pirogue\dispatcher');
    import('pirogue\database_collection');
    import('pirogue\route');
    import('pirogue\view_html');

    set_error_handler('pirogue\_dispatcher_error_handler');

    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    /* Initialize libraries: */
    __dispatcher(sprintf('%s://%s/example-site/auth', ('off' == $_SERVER['HTTPS']) ? 'http' : 'https', $_SERVER['SERVER_NAME']), $_request_path, $_request_data);
    __database_collection(sprintf('%s\config', _BASE_FOLDER));
    __route(sprintf('%s\view\html', _BASE_FOLDER), 'phtml');

    // Route path to controller file, function & path:
    $_exec_data = $_request_data;
    $_exec_path = _route_clean($_request_path);
    $_route = _route_parse($_exec_path);
    $_html_content = '';

    if (false == file_exists($_route['file'])) {
        $_route = _route_parse('_error-404');
        $_exec_data = [
            $_request_path,
            $_request_data
        ];
    }

    /* process request */
    try {
        $_html_content = _view_html_load($_route['file'], $_route['path'], $_exec_data);
    } catch (Exception $_exception) {
        http_response_code(500);
        $_route = _route_parse('_error-500');
        $_exec_data = [
            $_request_path,
            $_request_data,
            $_exception
        ];

        $_html_content = _view_html_load($_route['file'], $_route['path'], $_exec_data);
    } catch (Error $_exception) {
        http_response_code(500);
        $_route = _route_parse('_error-500');
        $_exec_data = [
            $_request_path,
            $_request_data,
            $_exception
        ];

        $_html_content = _view_html_load($_route['file'], $_route['path'], $_exec_data);
    }

    ob_end_clean();
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






