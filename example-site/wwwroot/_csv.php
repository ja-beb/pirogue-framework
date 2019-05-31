<?php
$GLOBALS['._csv.dispatcher.start_time'] = microtime(true);

use function pirogue\__database_collection;
use function pirogue\__import;
use function pirogue\_dispatcher_send;
use function pirogue\_route_clean;
use function pirogue\_route_parse;
use function pirogue\import;
use function pirogue\__route;
use function pirogue\__dispatcher;

/**
 * Main dispatcher for CSV content.
 * Processes user request and routes it to the proper file in _csv/[Module]/[Name].inc 
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */
function _route_execute(string $file, string $path, array $data): array
{
    if (file_exists($file)) {
        ob_start();
        $GLOBALS['.pirogue.view.data'] = $data;
        $GLOBALS['.pirogue.view.path'] = $path;
        $_csv_data = require $file;
        ob_get_clean();

        return is_array($_csv_data) ? $_csv_data : [
            $_csv_data
        ];
    }
    throw new ErrorException(sprintf("Unable to find requested resource '$file'."));
}

// Send request headers (type for this dispatcher):
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

    /* Initialize libraries: */
    __dispatcher(sprintf('%s://%s/example-site/auth', ('off' == $_SERVER['HTTPS']) ? 'http' : 'https', $_SERVER['SERVER_NAME']));
    __database_collection(sprintf('%s\config', _BASE_FOLDER));
    __route(sprintf('%s\view\csv', _BASE_FOLDER), 'inc');

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Route path to controller file, function & path:
    $_exec_data = $_request_data;

    $_exec_path = _route_clean($_request_path);
    $_route = _route_parse($_exec_path);
    $_csv_data = [];

    /* process request */
    try {

        if (file_exists($_route['file'])) {
            ob_start();
            $_csv_data = _route_execute($_route['file'], $_route['path'], $_exec_data);
            ob_clean();
        } else {
            http_response_code(404);
        }
    } catch (Exception $_exception) {
        http_response_code(500);
        header(sprintf('X-Execute-Error: %s (%s: %d).', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine()));
    } catch (Error $_exception) {
        http_response_code(500);
        header(sprintf('X-Execute-Error: %s (%s: %d).', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine()));
    }

    header('Content-Type: application/csv', true);
    header('X-Powered-By: pirogue php');
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._csv.dispatcher.start_time']) * 1000));

    // Write csv data to memory then transfer to string.
    $f = fopen('php://memory', 'r+');
    foreach ($_csv_data as $_row) {
        fputcsv($f, $_row);
    }
    rewind($f);
    $csv_line = stream_get_contents($f);
    return _dispatcher_send(rtrim($csv_line));
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

// Failsafe errors:
header('X-Powered-By: pirogue php');
header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._csv.dispatcher.start_time']) * 1000));
http_response_code(500);
header(sprintf('X-Error: %s (%s:%d)', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getMessage(), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getFile(), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getLine()));



