<?php 
    
    
    set_error_handler(function(int $errno, string $errstr, string $errfile, int $errline){
            if ($errno & error_reporting()) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
            return false;
        });

    // Start sessions & error handling

    // Initialize config for database
    // Set current
    $GLOBALS['.pirogue.html.body.id'] = '';    
$GLOBALS['.pirogue.html.head'] = '';
$GLOBALS['.pirogue.html.head.title'] = '';
$GLOBALS['.pirogue.html.body.class'] = '';
$GLOBALS['.pirogue.html.css.files'] = '';
$GLOBALS['.pirogue.html.css.inline'] = '';
$GLOBALS['.pirogue.html.script.inline'] = '';
$GLOBALS['.pirogue.html.script.files'] = '';


    try {

        try{
            $GLOBALS['.view_path'] = '/var/www/view';
            $GLOBALS['.config_path'] = '/var/www/config';

            $GLOBALS['.request_data'] = $_GET;
            $GLOBALS['.request_path'] = $GLOBALS['.request_data']['__execution_path'] ?? '';
            unset($GLOBALS['.request_data']['__execution_path']);

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

            ob_start();
            require($_view_file);
            $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();

        } catch (Exception $exception) {
            $_view_file = sprintf('%s/_500.phtml', $GLOBALS['.view_path']);
            
            ob_start();
            require($_view_file);
            $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
        } catch (Error $error) {
            $_view_file = sprintf('%s/_500.phtml', $GLOBALS['.view_path']);
            
            ob_start();
            require($_view_file);
            $GLOBALS['.pirogue.html.body.content'] = ob_get_clean();
        }
        
        ob_start();
        require( sprintf('%s/_page.phtml', $GLOBALS['.view_path']) );
        $_content = ob_get_clean();

        echo $_content;

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