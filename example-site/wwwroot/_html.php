<?php
/**
 * Main dispatcher for html content.
 *
 * Processes user request and routes it to the proper function found the requested module file in view/html/[ModuleName].inc - handles any REST method
 * that the developer writes end point for.
 *
 * @example For any HTTP method:
 *          site.url/page.html?data=my_data
 *          include(html/page.inc);
 *
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */
ob_start();

// define global variables
$GLOBALS['._html.dispatcher.start_time'] = microtime(true);
$GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;

// define site contants.
define('_BASE_FOLDER', 'C:\\inetpub\example-site');
define('_SITE_URL', sprintf('%s://%s/example-site', ('off' == $_SERVER['HTTPS']) ? 'http' : 'https', $_SERVER['SERVER_NAME']));

// define functions used
use function pirogue\__database_collection;
use function pirogue\__dispatcher;
use function pirogue\__import;
use function pirogue\__route;
use function pirogue\__user_session;
use function pirogue\_dispatcher_exit;
use function pirogue\_dispatcher_send;
use function pirogue\_route_clean;
use function pirogue\_route_parse;
use function pirogue\_view_html_load;
use function pirogue\dispatcher_redirect;
use function pirogue\import;
use function pirogue\user_session_current;
use function pirogue\view_html_route_error;
use function pirogue\view_html_route_not_found;

try {

    // bootstrap dispatcher - load & intialize pirogue framework.
    require_once sprintf('%s\include\pirogue\import.inc', _BASE_FOLDER);
    __import(sprintf('%s\include', _BASE_FOLDER));

    // import base disaptcher library.
    import('pirogue\dispatcher');
    import('pirogue\error_handler');

    // bootstrap dispatcher - error handler.
    set_error_handler('pirogue\_error_handler');

    // bootstrap dispatcher - load config.
    $_config = parse_ini_file(sprintf('%s\config\site.ini', _BASE_FOLDER));

    // bootstrap dispatcher - start session & register callback.
    session_start([
        'name' => $_config['session.name']
    ]);
    register_shutdown_function('session_write_close');

    // bootstrap dispatcher - parse request into path & data.
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // bootstrap dispatcher - initialize user session library.
    import('pirogue\user_session');
    __user_session($_config['user_session.label']);

    // check for existing session.
    $_user_session = user_session_current();
    if (null == $_user_session) {
        // build redirect request
        $_request_data['redirect_path'] = $_request_path;
        return dispatcher_redirect(sprintf('%s/auth.html?%s', _SITE_URL, http_build_query($_request_data)));
    }

    // bootstrap dispatcher - import and initialize required libraries.
    import('pirogue\database_collection');
    import('pirogue\route');

    __route(sprintf('%s\view\html', _BASE_FOLDER), 'phtml');
    __dispatcher(_SITE_URL, $_request_path, $_request_data);
    __database_collection(sprintf('%s\config', _BASE_FOLDER), $_config['database.default']);

    // process request.
    import('pirogue\view_html');
    $_content = '';
    try {
        // route path to controller file, function & path.
        $_exec_data = $_request_data;
        $_exec_path = _route_clean($_request_path);
        $_route = _route_parse($_exec_path);
        $_route = view_html_route_not_found($_request_path, $_request_data);
        $_content = _view_html_load($_route['file'], $_route['path'], $_exec_data);
    } catch (Exception $_exception) {
        $_content = view_html_route_error($_exception, $_request_path, $_request_data);
    } catch (Error $_exception) {
        $_content = view_html_route_error($_exception, $_request_path, $_request_data);
    }

    // send resuts to user.
    header('Content-Type: text/html');
    header('X-Powered-By: pirogue php');
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._html.dispatcher.start_time']) * 1000));
    ob_end_clean();

    $_route = _route_parse('_page');
    $_content = _view_html_load($_route['file'], '', [
        'content' => $_content
    ]);
    return _dispatcher_send($_content);
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

// failsafe errors.
header('Content-Type: text/html');
header('X-Powered-By: pirogue php');
header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._html.dispatcher.start_time']) * 1000));
http_response_code(500);

if ($GLOBALS['._pirogue.dispatcher.failsafe_exception']) {
    printf('ERROR %s: (%s:%d)', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getMessage(), str_replace(_BASE_FOLDER, '', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getFile()), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getLine());
} else {
    echo 'Unknown exception encountered';
}

_dispatcher_exit();
