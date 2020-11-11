<?php 
    use function pirogue\import_init;
    use function pirogue\import;
    use function pirogue\dispatcher_init;
    use function pirogue\_dispatcher_send;
    use function pirogue\_dispatcher_exit;


    set_error_handler(function(int $errno, string $errstr, string $errfile, int $errline){
            if ($errno & error_reporting()) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
            return false;
        });

    // Start sessions & error handling

    // Initialize config for database
    try {

        try{

            import_init('/var/www/include');

            $GLOBALS['.view_path'] = '/var/www/view';
            $GLOBALS['.config_path'] = '/var/www/config';

            $GLOBALS['.request_data'] = $_GET;
            $GLOBALS['.request_path'] = $GLOBALS['.request_data']['__execution_path'] ?? '';
            unset($GLOBALS['.request_data']['__execution_path']);

            dispatcher_init('https://invlabsserver.local', $GLOBALS['.request_path'], $GLOBALS['.request_data']);

            // Get controller file.
            $_path = array_map(function ($v) {
                return preg_replace('/^(_+)/', '', $v);
            }, explode('/', $GLOBALS['.request_path']));

            $_page = array_shift($_path);
            $_page = empty($_page) ? 'index' : $_page;

            // Translate from request_path to (module, page, path)
            $GLOBALS['.request_path'] = implode('/', $_path);

            // Check for view file:
            $_view_file = sprintf('%s/%s.phtml', $GLOBALS['.view_path'], $_page);
            if ( false == file_exists($_view_file) ){
                $_view_file = sprintf('%s/_404.phtml', $GLOBALS['.view_path']);
            }

            // Initialize view variables
            $GLOBALS['.html.head'] = '';
            $GLOBALS['.html.head.title'] = '';
            $GLOBALS['.html.css.files'] = [];
            $GLOBALS['.html.css.inline'] = '';
            $GLOBALS['.html.script.inline'] = '';
            $GLOBALS['.html.script.files'] = [];
            $GLOBALS['.html.body.class'] = '';
            $GLOBALS['.html.body.id'] = '';       
            
            // Load requested view
            ob_start();
            require($_view_file);
            $GLOBALS['.html.body.content'] = ob_get_clean();

        } catch (Exception $exception) {
            ob_start();
            $GLOBALS['.error.exception'] = $exception;
            require(sprintf('%s/_500.phtml', $GLOBALS['.view_path']));
            $GLOBALS['.html.body.content'] = ob_get_clean();
        } catch (Error $error) {
            ob_start();
            $GLOBALS['.error.exception'] = $error;
            require(sprintf('%s/_500.phtml', $GLOBALS['.view_path']));
            $GLOBALS['.html.body.content'] = ob_get_clean();
        }

        ob_start();
        require(sprintf('%s/_page.phtml', $GLOBALS['.view_path']));
        $_content = ob_get_clean();

        // Send content to user
        _dispatcher_send($_content);

    } catch (Exception $exception) {
        // Fatal error, unrecoverable:
        ob_get_clean();
        printf('%s: >> Encountered error "%s" at %s (%d)', date( DATE_ISO8601), $exception->getMessage(),$exception->getFile(), $exception->getLine());
        // return _dispatcher_send_error(500, sprintf('%s > %s (%d)', $exception->getMessage(), $exception->getFile(), $exception->getLine()));
    } catch (Error $error) {
        // Fatal error, unrecoverable:
        ob_get_clean();
        printf('%s: >> Encountered error "%s" at %s (%d)', date( DATE_ISO8601), $error->getMessage(),$error->getFile(), $error->getLine());
        // return _dispatcher_send_error(500, sprintf('%s > %s (%d)', $error->getMessage(), $error->getFile(), $error->getLine()));
    }