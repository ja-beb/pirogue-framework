<?php
/**
 * Main dispatcher for AUTH content.
 *
 * Processes user request and routes it to the proper function found the requested module file in view/html-auth/[ModuleName].inc - handles any REST method
 * that the developer writes end point for.
 *
 * @example For any HTTP method:
 *          site.url/auth/page.html?data=my_data
 *          include(html-auth/page.inc);
 *
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */
ob_start();

// define global variables
$GLOBALS['._pirogue.dispatcher.start_time'] = microtime(true);
$GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;

// define use functions.
use function pirogue\__database_collection;
use function pirogue\__dispatcher;
use function pirogue\__import;
use function pirogue\__user_session;
use function pirogue\__html;
use function pirogue\_dispatcher_send;
use function pirogue\_html_clear;
use function pirogue\_html_get_path;
use function pirogue\dispatcher_create_url;
use function pirogue\dispatcher_redirect;
use function pirogue\import;
use function pirogue\user_session_current;


/**
 * dispatcher's exception handler.
 * @param Exception $exception
 */
function _html_handle_exception($exception){
    _html_clear($GLOBALS['.pirogue.request.application'], [
        'body.class' => 'error-500'
    ]);
    
    $GLOBALS['.pirogue.request.data'] = [
        'error_message' => sprintf('%s at %s #%d.', $exception->getMessage(), $exception->getFile(), $exception->getLine()),
        'request' => [
            'application' => $GLOBALS['.pirogue.request.application'],
            'path' => $GLOBALS['.pirogue.request.path'],
            'data' => $GLOBALS['.pirogue.request.data']
        ]
    ];
    
    $GLOBALS['.pirogue.request.application'] = '';
    $GLOBALS['.pirogue.request.path'] = '';
    
    _html_clear($GLOBALS['.pirogue.request.application'], []);
    ob_start();
    require _html_get_path('_site-errors\500.phtml');
    $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();    
}

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
    $GLOBALS['.pirogue.request.data'] = $_GET;
    $GLOBALS['.pirogue.request.path'] = $GLOBALS['.pirogue.request.data']['__execution_path'] ?? '';
    unset($GLOBALS['.pirogue.request.data']['__execution_path']);

    // bootstrap dispatcher - initialize dispatcher & user session library.
    dispatcher_init('http://invlabsServer/example-site/auth', $GLOBALS['.pirogue.request.path'], $GLOBALS['.pirogue.request.data']);
    user_session_init('._example-site.user_session');

    // check for existing session - if exists redirect to site.
    $_user_session = user_session_current();
    if (null != $_user_session) {
        $_redirect = $GLOBALS['.pirogue.request.data']['redirect_path'] ?? '';
        $_redirect = preg_match('/^auth/', $_redirect) ? '' : $_redirect;
        return dispatcher_redirect(dispatcher_create_url(empty($_redirect) ? '..' : $_redirect));
    }

    // bootstrap dispatcher - import and initialize libraries used to build request content.
    import('pirogue\database_collection');
    import('pirogue\html');
    database_collection_init('C:\\inetpub\example-site\config', 'example-site');
    html_init('C:\\inetpub\example-site\view\html-auth');

    // send resuts to user.
    header('Content-Type: text/html');
    header('X-Powered-By: pirogue php');

    // load page content into the page template
    $GLOBALS['.pirogue.request.url'] = dispatcher_create_url($GLOBALS['.pirogue.dispatcher.request_path'], $GLOBALS['.pirogue.dispatcher.request_data']);
    
    try {
        // route parse: (application, page, path)
        $_path = explode('/', $GLOBALS['.pirogue.request.path']);
        $GLOBALS['.pirogue.request.application'] = '';

        if (1 == count($_path)) {
            $_view_name = preg_replace('/^(_+)/', '', $_path[0] ?? '');
        } else {
            $GLOBALS['.pirogue.request.application'] = preg_replace('/^(_+)/', '', $_path[0] ?? '');
            $_view_name = preg_replace('/^(_+)/', '', $_path[1] ?? '');
        }
        $GLOBALS['.pirogue.request.path'] = implode('/', array_splice($_path, 2));

        $_view_name = empty($_view_name) ? 'index' : $_view_name;
        $_view_application = empty($GLOBALS['.pirogue.request.application']) ? '_login' : $GLOBALS['.pirogue.request.application'];
        $_view_path = sprintf('%s\%s.phtml', $_view_application, $_view_name);
        $_view_file = _html_get_path($_view_path);

        if (empty($_view_file)) {
            $GLOBALS['.pirogue.request.data'] = [
                'error_message' => "Unable to find view {$_view_path}",
                'request' => [
                    'application' => $GLOBALS['.pirogue.request.application'],
                    'path' => $GLOBALS['.pirogue.request.path'],
                    'data' => $GLOBALS['.pirogue.request.data']
                ]
            ];
            $GLOBALS['.pirogue.request.application'] = '';
            $GLOBALS['.pirogue.request.path'] = '';
            $_view_file = _html_get_path('_site-errors\404.phtml');
        }

        _html_clear($GLOBALS['.pirogue.request.application'], []);
        ob_start();
        require $_view_file;
        $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
    } catch (Exception $_exception) {
        _html_handle_exception($_exception);
    } catch (Error $_exception) {
        _html_handle_exception($_exception);
    }

    // load content into page
    ob_start();
    require _html_get_path('_site\page.phtml');
    $_content = ob_get_clean();

    // Clear any remaining buffers.
    while (0 < ob_get_level()) {
        ob_get_clean();
    }

    header(sprintf('X-Execute-Milliseconds: %0.00f', (microtime(true) - $GLOBALS['._pirogue.dispatcher.start_time']) * 1000));
    return _dispatcher_send($_content);
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

require '_html-fatal-error.inc';
