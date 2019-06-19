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

// define use functions.
use function pirogue\__database_collection;
use function pirogue\__dispatcher;
use function pirogue\__import;
use function pirogue\__user_session;
use function pirogue\__view_html;
use function pirogue\_dispatcher_send;
use function pirogue\_view_html_clear;
use function pirogue\_view_html_get_path;
use function pirogue\dispatcher_create_url;
use function pirogue\dispatcher_redirect;
use function pirogue\import;
use function pirogue\user_session_current;
use function pirogue\database_collection_get;
use function site_access\site_access_fetch;


/**
 * dispatcher's exception handler.
 * @param Exception $exception
 */
function _view_html_handle_exception($exception)
{
    _view_html_clear($GLOBALS['.pirogue.request.application'], [
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

    _view_html_clear($GLOBALS['.pirogue.request.application'], []);
    ob_start();
    require _view_html_get_path('site\_500.phtml');
    $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
}

try {

    // bootstrap dispatcher
    require_once 'C:\\inetpub\example-site\include\pirogue\import.inc';
    __import('C:\\inetpub\example-site\include');

    import('pirogue\error_handler');
    import('pirogue\dispatcher');
    import('pirogue\user_session');

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
    __dispatcher('http://invlabsServer/example-site', $GLOBALS['.pirogue.request.path'], $GLOBALS['.pirogue.request.data']);
    __user_session('._example-site.user_session');


    // load page content into the page template
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
    import('pirogue\view_html');
    import('site_access');

    __database_collection('C:\\inetpub\example-site\config', 'example-site');
    __view_html('C:\\inetpub\example-site\view\html');

    // send resuts to user.
    header('Content-Type: text/html');
    header('X-Powered-By: pirogue php');

    try {
        // route parse: (application, page, path)
        $_path = explode('/', $GLOBALS['.pirogue.request.path']);
        $GLOBALS['.pirogue.request.application'] = '';
        $GLOBALS['.pirogue.request.path'] = '';
        $GLOBALS['.pirogue.request.page'] = '';
        
        $_path_count = count($_path);        
        if (1 == $_path_count) {
            $GLOBALS['.pirogue.request.page'] = preg_replace('/^(_+)/', '', $_path[0] ?? '');
        } elseif (1 < $_path_count) {
            $GLOBALS['.pirogue.request.application'] = preg_replace('/^(_+)/', '', $_path[0] ?? '');
            $GLOBALS['.pirogue.request.page'] = preg_replace('/^(_+)/', '', $_path[1] ?? '');
            $GLOBALS['.pirogue.request.path'] = implode('/', array_splice($_path, 2));
        }
        
        // verify application access.
        $_view_file = '';
        $GLOBALS['.pirogue.request.page'] = empty($GLOBALS['.pirogue.request.page']) ? 'index' : $GLOBALS['.pirogue.request.page'];
        $_view_application = empty($GLOBALS['.pirogue.request.application']) ? 'site' : $GLOBALS['.pirogue.request.application'];
        
        // load presentation file
        $GLOBALS['.pirogue.html.body.menu_file'] = _view_html_get_path("{$_view_application}\_menu.phtml");       
        
        $_sqlsrv = database_collection_get();
        $GLOBALS['.pirogue.site_access.roles'] = site_access_fetch($_sqlsrv, $_user_session['id'], $_view_application);

        if (0 == count($GLOBALS['.pirogue.site_access.roles'])) {
            // site user does not have access to application, display site-wide 403 page.
            // does the application exists? if not clear out requested application too.
            $GLOBALS['.pirogue.request.data'] = [
                'error_message' => "Your account has not been assigned access to the application {$GLOBALS['.pirogue.request.application']}",
                'request' => [
                    'application' => $GLOBALS['.pirogue.request.application'],
                    'path' => $GLOBALS['.pirogue.request.path'],
                    'data' => $GLOBALS['.pirogue.request.data']
                ]
            ];
            $GLOBALS['.pirogue.request.application'] = '';
            $GLOBALS['.pirogue.request.path'] = '';
            $GLOBALS['.pirogue.html.body.menu_file'] = '';
            $_view_file = _view_html_get_path('site\_403.phtml');
        } else {
            $_view_path = sprintf('%s\%s.phtml', $_view_application, $GLOBALS['.pirogue.request.page']);
            $_view_file = _view_html_get_path($_view_path);

            if (empty($_view_file)) {
                // does the application exists? if not clear out requested application too.
                $GLOBALS['.pirogue.request.data'] = [
                    'error_message' => ('' == _view_html_get_path($_view_application)) ? "Unable to find application {$_view_application}" : "Unable to find view {$_view_path}",
                    'request' => [
                        'application' => $GLOBALS['.pirogue.request.application'],
                        'path' => $GLOBALS['.pirogue.request.path'],
                        'data' => $GLOBALS['.pirogue.request.data']
                    ]
                ];
                $GLOBALS['.pirogue.request.application'] = '';
                $GLOBALS['.pirogue.request.path'] = '';
                $_view_file = _view_html_get_path('site\_404.phtml');
                
            }
        }
        
        $GLOBALS['.pirogue.site_access.has_access'] = true;
        _view_html_clear($GLOBALS['.pirogue.request.application'], []);
        ob_start();
        require $_view_file;
        $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
        
        // Access denied.
        if ( false == $GLOBALS['.pirogue.site_access.has_access'] ){
            _view_html_clear($GLOBALS['.pirogue.request.application'], []);
            ob_start();
            require _view_html_get_path('site\_403.phtml');
            $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
        }
    } catch (Exception $_exception) {
        _view_html_handle_exception($_exception);
    } catch (Error $_exception) {
        _view_html_handle_exception($_exception);
    }

    // load menu file.
    $_menu_file = $GLOBALS['.pirogue.html.body.menu_file'] ?? '';
    if ( false == empty($_menu_file) ){
        ob_start();        
        require $_menu_file;
        $GLOBALS['.pirogue.html.body.menu'] = ob_get_clean();
    }

    // load content into page
    ob_start();
    require _view_html_get_path('site\_page.phtml');
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
