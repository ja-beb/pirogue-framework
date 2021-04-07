<?php

namespace html;

use function pirogue\import_init;
use function pirogue\import;
use function pirogue\dispatcher_init;
use function pirogue\dispatcher_create_url;
use function pirogue\dispatcher_redirect;
use function pirogue\_dispatcher_send;
use function pirogue\_dispatcher_exit;
use function pirogue\cdn_init;
use function pirogue\user_session_init;
use function pirogue\user_session_current;
use function pirogue\database_collection_init;
use function pirogue\site_notices_init;

// Start timer.
$GLOBALS['._dispatcher.start_time'] = microtime(true);

set_error_handler('pirogue\_error_handler');
ob_start();

/**
 * Load 500 error.
 *
 * @param mixed $exception
 *            Exception or error thrown.
 * @param string $view_path
 *            Path to view files.
 */
function __dispatcher_load_error($exception, string $view_path): string
{
    $GLOBALS['.dispatcher.exception'] = $exception;

    ob_start();
    require sprintf('%s/_500.phtml', $view_path);
    return ob_get_clean();
}

// Start sessions & error handling

// Initialize config for database
try {

    try {
        // Initialize global & page variabgles.
        $GLOBALS['.dispatcher.exception'] = null;
        $GLOBALS['.request.page'] = '';
        $GLOBALS['.request.page_path'] = '';
        $GLOBALS['._dispatcher.page_template'] = '_page';

        // dispatcher pathes
        $GLOBALS['.dispatcher.path.view'] = '/var/www/view';
        $GLOBALS['.dispatcher.path.config'] = '/var/www/config';

        // Import framework constants (does not work on opcache).
        require_once '/var/www/pirogue/constants.inc';
        require_once '/var/www/include/constants.inc';
        
        // Process user request.
        $GLOBALS['.request.data'] = $_GET;
        $GLOBALS['.request.path'] = $GLOBALS['.request.data']['__execution_path'] ?? '';
        unset($GLOBALS['.request.data']['__execution_path']);

        dispatcher_init('https://pirogue-testing.local', $GLOBALS['.request.path'], $GLOBALS['.request.data']);
        user_session_init('._pirogue.user_session');
        cdn_init([
            'https://cdn.pirogue-testing.local'
        ]);
        site_notices_init('._pirogue.site_notices');
        database_collection_init($GLOBALS['.dispatcher.path.config'], 'website');

        // Get controller file.
        $_path = array_map(function ($v) {
            return preg_replace('/^(_+)/', '', $v);
        }, explode('/', $GLOBALS['.request.path']));

        // Get modules & page
        $GLOBALS['.request.page'] = array_shift($_path);
        $GLOBALS['.request.page'] = empty($GLOBALS['.request.page']) ? '' : $GLOBALS['.request.page'];

        // Translate from request_path to (module, page, path)
        $GLOBALS['.request.page_path'] = implode('/', $_path);
                
        // Initialize view variables
        $GLOBALS['.html.head'] = '';
        $GLOBALS['.html.head.title'] = '';
        $GLOBALS['.html.css.files'] = [];
        $GLOBALS['.html.css.inline'] = '';
        $GLOBALS['.html.script.inline'] = '';
        $GLOBALS['.html.script.files'] = [];
        $GLOBALS['.html.body.class'] = '';
        $GLOBALS['.html.body.id'] = '';
        $GLOBALS['.html.body.page_menu'] = '';
        $GLOBALS['.html.body.title'] = '';
                
        // Check for view file:
        function _dispatcher_get_view(array $path): ?string
        {
            $_view_file = sprintf('%s.phtml', implode(DIRECTORY_SEPARATOR, $path));
            return file_exists($_view_file) ? $_view_file : null;
        }

        if ( empty($GLOBALS['.request.page']) ){
            $_view_file = _dispatcher_get_view([$GLOBALS['.dispatcher.path.view'], 'index']);
        }else{
            $_view_file = sprintf('%s/%s.phtml', $GLOBALS['.dispatcher.path.view'], $GLOBALS['.request.page']);
        }            
    
        
        if (false == file_exists($_view_file)) {
            $_view_file = sprintf('%s/_404.phtml', $GLOBALS['.dispatcher.path.view']);
        }
        
        // Load requested view
        ob_start();
        require $_view_file;
        $GLOBALS['.html.body.content'] = ob_get_clean();
        
        
    } catch (\Exception $exception) {
        $GLOBALS['.html.body.content'] = __dispatcher_load_error($exception, $GLOBALS['.dispatcher.path.view']);
    } catch (\Error $error) {
        $GLOBALS['.html.body.content'] = __dispatcher_load_error($error, $GLOBALS['.dispatcher.path.view']);
    }

    // Load template
    ob_start();
    require (sprintf('%s/%s.phtml', $GLOBALS['.dispatcher.path.view'], $GLOBALS['._dispatcher.page_template']));
    $_content = ob_get_clean();

    // Calculate execution time and send to user.
    $_diff = microtime(true) - $GLOBALS['._dispatcher.start_time'];
    $_sec = intval($_diff);
    $_micro = $_diff - $_sec;
    $_final = strftime('%T', mktime(0, 0, $_sec)) . str_replace('0.', '.', sprintf('%.3f', $_micro));
    header(sprintf('x-execution-time: %s', $_final));

    // Send content to user.
    ob_get_clean();
    _dispatcher_send($_content);
} catch (\Exception $exception) {
    // Fatal error, unrecoverable:
    ob_get_clean();
    printf('%s: >> Encountered error "%s" at %s (%d)', date(DATE_ISO8601), $exception->getMessage(), $exception->getFile(), $exception->getLine());
    echo '<pre>';
    print_r($exception);
    echo '</pre>';
} catch (\Error $error) {
    // Fatal error, unrecoverable:
    ob_get_clean();
    printf('%s: >> Encountered error "%s" at %s (%d)', date(DATE_ISO8601), $error->getMessage(), $error->getFile(), $error->getLine());
    echo '<pre>';
    print_r($error);
    echo '</pre>';
}

// Exit page.
exit();