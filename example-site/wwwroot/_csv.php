<?php
/**
 * Main dispatcher for CSV content.
 * Processes user request and routes it to the proper module file in view/csv/[Module]/[Page].inc
 *
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */
ob_start();

// define global variables
$GLOBALS['._pirogue.dispatcher.start_time'] = microtime(true);
$GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;

use function pirogue\__database_collection;
use function pirogue\__dispatcher;
use function pirogue\__import;
use function pirogue\__user_session;
use function pirogue\_dispatcher_exit;
use function pirogue\_dispatcher_send;
use function pirogue\dispatcher_create_url;
use function pirogue\import;
use function pirogue\user_session_current;

/**
 * Load csv view file and return results.
 *
 * @param string $path
 * @param array $data
 * @return mixed
 */
function _view_load(string $file, string $application, string $path, array $data)
{
    if (false == file_exists($file)) {
        throw new ErrorException("Unable to find requested resource: {$file}");
    }

    // declare base request data
    $GLOBALS['.pirogue.request.application'] = $application;
    $GLOBALS['.pirogue.request.path'] = $path;
    $GLOBALS['.pirogue.request.data'] = $data;

    ob_start();
    $_data = require $file;
    ob_get_clean();
    return $_data;
}

header('Content-Type: application/csv', true);
header('X-Powered-By: pirogue php');

try {
    // bootstrap dispatcher
    require_once 'C:\\inetpub\example-site\include\pirogue\import.inc';
    import_init('C:\\inetpub\example-site\include');

    import('pirogue\error_handler');
    import('pirogue\user_session');
    import('pirogue\dispatcher');

    set_error_handler('pirogue\_error_handler');
    session_start([
        'name' => 'example-site'
    ]);
    register_shutdown_function('session_write_close');

    // bootstrap dispatcher - parse request into path & data.
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // bootstrap dispatcher - initialize dispatcher & user session library.
    dispatcher_init('http://invlabsServer/example-site', $_request_path, $_request_data);
    user_session_init('._example-site.user_session');

    // check for existing session - if exists redirect to site.
    $_user_session = user_session_current();
    if (null == $_user_session) {
        http_response_code(403);
        _dispatcher_exit();
    }

    // bootstrap dispatcher - import and initialize libraries used to build request content.
    import('pirogue\database_collection');
    database_collection_init('C:\\inetpub\example-site\config', 'example-site');

    // send resuts to user.
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._pirogue.dispatcher.start_time']) * 1000));

    // load page content into the page template
    $GLOBALS['.pirogue.request.url'] = dispatcher_create_url($GLOBALS['.pirogue.dispatcher.request_path'], $GLOBALS['.pirogue.dispatcher.request_data']);
    $GLOBALS['.pirogue.csv.data'] = null;

    try {
        // route parse: (application, page, path)
        $_exec_path = explode('/', $_request_path);

        if (1 == count($_exec_path)) {
            $_exec_application = '';
            $_exec_page = preg_replace('/^(_+)/', '', $_exec_path[0] ?? '');
        } else {
            $_exec_application = preg_replace('/^(_+)/', '', $_exec_path[0] ?? '');
            $_exec_page = preg_replace('/^(_+)/', '', $_exec_path[1] ?? '');
        }

        $_exec_page = sprintf('C:\\inetpub\example-site\view\csv\%s\%s.inc', $_exec_application, $_exec_page);
        if (empty($_exec_page)) {
            http_response_code(404);
        } else {
            $GLOBALS['.pirogue.csv.filename'] = sprintf('%s-%s.csv', $_exec_path[0] ?? '', $_exec_path[1] ?? '');
            $GLOBALS['.pirogue.csv.data'] = _view_load($_exec_page, $_exec_application, implode('/', array_splice($_exec_path, 2)), $_request_data);

            // Clear any remaining buffers.
            while (0 < ob_get_level()) {
                ob_get_clean();
            }

            // Write csv data to memory then transfer to string.
            $f = fopen('php://memory', 'r+');
            foreach ($GLOBALS['.pirogue.csv.data'] as $_row) {
                fputcsv($f, $_row);
            }
            rewind($f);
            $csv_line = stream_get_contents($f);
            header("Content-Disposition: attachment; filename={$GLOBALS['.pirogue.csv.filename']}");
            return _dispatcher_send(rtrim($csv_line));
        }
    } catch (Exception $_exception) {
        http_response_code(500);
        header(sprintf('X-ERROR: %s %s %d', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine()));
    } catch (Error $_exception) {
        http_response_code(500);
        header(sprintf('X-ERROR: %s %s %d', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine()));
    }
} catch (Error $_exception) {
    http_response_code(500);
    header(sprintf('X-ERROR: %s %s %d', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine()));
} catch (Exception $_exception) {
    http_response_code(500);
    header(sprintf('X-ERROR: %s %s %d', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine()));
}

return _dispatcher_exit();
