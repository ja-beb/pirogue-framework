<?php 

    function _html_reset()
    {
        $GLOBALS['.html.head'] = '';
        $GLOBALS['.html.head.title'] = '';
        $GLOBALS['.html.css.files'] = '';
        $GLOBALS['.html.css.inline'] = '';
        $GLOBALS['.html.body.content'] = '';
        $GLOBALS['.html.body.class'] = '';
        $GLOBALS['.html.body.id'] = '';
        $GLOBALS['.html.script.inline'] = '';
        $GLOBALS['.html.script.files'] = '';    
    }

    function _html_load_template(string $filename): string
    {
        ob_start();
        require($_view_file);
        return ob_get_clean();
    }

    
    set_error_handler(function(int $errno, string $errstr, string $errfile, int $errline){
            if ($errno & error_reporting()) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
            return false;
        });

    // Start sessions & error handling

    // Initialize config for database


    // Initialize view variables
    $GLOBALS['.html.head'] = '';
    $GLOBALS['.html.head.title'] = '';
    $GLOBALS['.html.css.files'] = '';
    $GLOBALS['.html.css.inline'] = '';
    $GLOBALS['.html.body.content'] = '';
    $GLOBALS['.html.body.class'] = '';
    $GLOBALS['.html.body.id'] = $id;
    $GLOBALS['.html.script.inline'] = '';
    $GLOBALS['.html.script.files'] = '';

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

            _html_reset()
            $GLOBALS['.html.body.content'] = _html_load_template($_view_file);

        } catch (Exception $exception) {
            _html_reset()
            $GLOBALS['.html.body.content'] = _html_load_template(sprintf('%s/_500.phtml', $GLOBALS['.view_path']));
        } catch (Error $error) {
            _html_reset()
            $GLOBALS['.html.body.content'] = _html_load_template(sprintf('%s/_500.phtml', $GLOBALS['.view_path']));
        }

        $_content = _html_load_template('', sprintf('%s/_page.phtml', $GLOBALS['.view_path']));

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