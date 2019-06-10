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

// define use functions:
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
function _view_load(string $file, string $application, string $path, array $data): string
{
    if (false == file_exists($file)) {
        throw new ErrorException('Unable to find requested view.');
    }

    // declare base request data
    $GLOBALS['.pirogue.request.application'] = $application;
    $GLOBALS['.pirogue.request.path'] = $path;
    $GLOBALS['.pirogue.request.data'] = $data;

    // declare base view data (load from data file).
    $GLOBALS['.pirogue.html.head'] = '';
    $GLOBALS['.pirogue.html.head.title'] = '';
    $GLOBALS['.pirogue.html.body.id'] = $application;
    $GLOBALS['.pirogue.html.body.class'] = '';
    $GLOBALS['.pirogue.html.css.files'] = [];
    $GLOBALS['.pirogue.html.css.inline'] = '';
    $GLOBALS['.pirogue.html.script.inline'] = '';
    $GLOBALS['.pirogue.html.script.files'] = [];

    ob_start();
    require $file;
    return ob_get_clean();
}

try {

    // bootstrap dispatcher
    require_once 'C:\\inetpub\example-site\include\pirogue\import.inc';
    __import('C:\\inetpub\example-site\include');

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
    __dispatcher('http://invlabsServer/example-site/auth', $_request_path, $_request_data);
    __user_session('._example-site.user_session');

    // check for existing session - if exists redirect to site.
    $_user_session = user_session_current();
    if (null != $_user_session) {
        $_redirect = $_request_data['redirect_path'] ?? '';
        $_redirect = preg_match('/^auth/', $_redirect) ? '' : $_redirect;
        return dispatcher_redirect(dispatcher_create_url(empty($_redirect) ? '..' : $_redirect));
    }

    // bootstrap dispatcher - import and initialize libraries used to build request content.
    import('pirogue\database_collection');
    __database_collection('C:\\inetpub\example-site\config', 'example-site');

    // send resuts to user.
    header('Content-Type: text/html');
    header('X-Powered-By: pirogue php');
    header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._pirogue.dispatcher.start_time']) * 1000));

    // load page content into the page template
    $GLOBALS['.pirogue.request.url'] = dispatcher_create_url($GLOBALS['.pirogue.dispatcher.request_path'], $GLOBALS['.pirogue.dispatcher.request_data']);
    
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
        
        $_exec_page = sprintf('C:\\inetpub\example-site\view\html-auth\%s\%s.phtml', empty($_exec_application) ? '_login' : $_exec_application, empty($_exec_page) ? 'index' : $_exec_page);
        if (empty($_exec_page)) {
            $GLOBALS['.pirogue.html.body.content'] = _view_load('C:\\inetpub\example-site\view\html-auth\_site-errors\404.phtml', '', '', []);
        } else {
            $GLOBALS['.pirogue.html.body.content'] =  _view_load($_exec_page, $_exec_application, implode('/', array_splice($_exec_path, 2)), $_request_data);
        }
    } catch (Exception $_exception) {
        $GLOBALS['.pirogue.html.body.content'] =  _view_load('C:\\inetpub\example-site\view\html-auth\_site-errors\500.phtml', '', '', [
            'error_message' => sprintf('%s at %s #%d.', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine())
        ]);
    } catch (Error $_exception) {
        $GLOBALS['.pirogue.html.body.content'] =  _view_load('C:\\inetpub\example-site\view\html-auth\_site-errors\500.phtml', '', '', [
            'error_message' => sprintf('%s at %s #%d.', $_exception->getMessage(), $_exception->getFile(), $_exception->getLine())
        ]);
    }
    
    // load content into page
    ob_start();
    require 'C:\\inetpub\example-site\view\html-auth\_page.phtml';
    $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
    
    // Clear any remaining buffers.
    while ( 0 < ob_get_level() ){
        ob_get_clean();
    }
    
    return _dispatcher_send($GLOBALS['.pirogue.html.body.content']);
} catch (Error $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
} catch (Exception $_exception) {
    $GLOBALS['._pirogue.dispatcher.failsafe_exception'] = $_exception;
}

require '_html-fatal-error.inc';
