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
$GLOBALS['._pirogue.dispatcher.start_time'] = microtime(true);
$GLOBALS['._pirogue.dispatcher.failsafe_exception'] = null;

// define use functions:\
use function pirogue\__database_collection;
use function pirogue\__dispatcher;
use function pirogue\__import;
use function pirogue\__user_session;
use function pirogue\_dispatcher_send;
use function pirogue\dispatcher_create_url;
use function pirogue\dispatcher_redirect;
use function pirogue\import;
use function pirogue\user_session_current;

/**
 * Load html view file into string buffer.
 *
 * @param string $path
 * @param array $data
 * @return string
 */
function _view_load(string $file, string $application, string $path, array $data, array $view_data): string
{
    if (false == file_exists($file)) {
        throw new ErrorException('Unable to find requested view.');
    }

    // declare base request data
    $GLOBALS['.pirogue.view_data'] = $view_data;
    $GLOBALS['.pirogue.request.path'] = $path;
    $GLOBALS['.pirogue.request.data'] = $data;

    // declare base view data (load from data file).
    $GLOBALS['.pirogue.view_data'] = $view_data;

    ob_start();
    require $file;
    return ob_get_clean();
}

/**
 * Load html view file into string buffer.
 *
 * @param string $path
 * @param array $data
 * @return string
 */
function _view_create(string $application, string $path, array $data): array
{
    // declare base request data
    return [
        'request' => [
            'application' => $application,
            'path' => $path,
            'data' => $data
        ],
        'html' => [
            'head' => [
                'title' => '',
                'content' => ''
            ],
            'body' => [
                'id' => $application,
                'class' => '',
                'title' => ''
            ],
            'css' => [
                'files' => '',
                'inline' => '',
            ],
            'script' => [
                'files' => '',
                'inline' => '',
            ]            
        ],
        'menu_file' => ''
    ];
}

try {

    // bootstrap dispatcher
    require_once 'C:\\inetpub\example-site\include\pirogue\import.inc';
    __import('C:\\inetpub\example-site\include');

    import('pirogue\error_handler');
    import('pirogue\user_session');
    import('pirogue\dispatcher');
    import('site_access');

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
    __dispatcher('http://invlabsServer/example-site', $_request_path, $_request_data);
    __user_session('._example-site.user_session');

    $GLOBALS['.pirogue.request.url'] = dispatcher_create_url($GLOBALS['.pirogue.dispatcher.request_path'], $GLOBALS['.pirogue.dispatcher.request_data']);

    // check for existing session - if exists redirect to site.
    $_user_session = user_session_current();
    if (null == $_user_session) {
        return dispatcher_redirect(dispatcher_create_url('auth', [
            'redirect_path' => $GLOBALS['.pirogue.request.url']
        ]));
    }

    // bootstrap dispatcher - import and initialize libraries used to build request content.
    import('pirogue\database_collection');
    __database_collection('C:\\inetpub\example-site\config', 'example-site');

    // send resuts to user.
    header('Content-Type: text/html');
    header('X-Powered-By: pirogue php');
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._pirogue.dispatcher.start_time']) * 1000));

    // load page content into the page template
    try {
        // route parse: (application, page, path)
        $_path = explode('/', $_request_path);

        if (0 == count($_path)) {
            $_exec_application = '';
            $_exec_page = '';
        } elseif (1 == count($_path)) {
            $_exec_application = '';
            $_exec_page = preg_replace('/^(_+)/', '', $_path[0] ?? '');
        } else {
            $_exec_application = preg_replace('/^(_+)/', '', $_path[0] ?? '');
            $_exec_page = preg_replace('/^(_+)/', '', $_path[1] ?? '');
        }

        $_exec_page = sprintf('C:\\inetpub\example-site\view\html\%s\%s.phtml', empty($_exec_application) ? '' : $_exec_application, empty($_exec_page) ? 'index' : $_exec_page);
        $_exec_path = implode('/', array_splice($_path, 2));
        if (empty($_exec_page)) {
            $GLOBALS['.pirogue.html.body.content'] = _view_load('C:\\inetpub\example-site\view\html\_site-errors\404.phtml', '', '', []);
        } else {
            $GLOBALS['.pirogue.html.body.content'] = _view_load($_exec_page, $_exec_application, $_exec_path, $_request_data);

            // check for 404 error:
            $GLOBALS['.pirogue.site_access.has_access'] = false;
        }
    } catch (Exception $_exception) {
        $GLOBALS['.pirogue.html.body.content'] = _view_load('C:\\inetpub\example-site\view\html\_site-errors\500.phtml', '', '', [
            'error_message' => sprintf('%s at %s #%d.', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine())
        ]);
    } catch (Error $_exception) {
        $GLOBALS['.pirogue.html.body.content'] = _view_load('C:\\inetpub\example-site\view\html\_site-errors\500.phtml', '', '', [
            'error_message' => sprintf('%s at %s #%d.', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine())
        ]);
    }

    // load menu
    if (file_exists($GLOBALS['.pirogue.html.body.menu_file'])) {
        ob_start();
        require $GLOBALS['.pirogue.html.body.menu_file'];
        $GLOBALS['.pirogue.html.body.menu'] = ob_get_clean();
    } else {
        $GLOBALS['.pirogue.html.body.menu'] = '';
    }

    // load content into page
    ob_start();
    $GLOBALS['.pirogue.request.application'] = $_exec_application;
    $GLOBALS['.pirogue.request.path'] = $_exec_path;
    $GLOBALS['.pirogue.request.data'] = $_exec_page;
    require 'C:\\inetpub\example-site\view\html\_page.phtml';
    $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();

    // Clear any remaining buffers.
    while (0 < ob_get_level()) {
        ob_get_clean();
    }

    return _dispatcher_send($GLOBALS['.pirogue.html.body.content']);
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

require '_html-fatal-error.inc';
