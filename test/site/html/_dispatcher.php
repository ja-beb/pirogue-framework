<?php 

    ob_start();
    
    // define constants.
    define('_PIROGUE_PATH', '/var/www');
    define('_PIROGUE_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'include']));
    define('_PIROGUE_PATH_VIEW', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'view']));
    define('_PIROGUE_PATH_CONFIG', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'config']));

    // load autoloader.
    require implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH_INCLUDE, 'pirogue', 'import.php']);

    try {
        pirogue_import_init(_PIROGUE_PATH_INCLUDE);

        // load and register error handler.
        pirogue_import_load('pirogue/error_handler');
        set_error_handler('_pirogue_error_handler');

        
        try {
            $_request_data = $_GET;
            $_request_path = $_request_data['__execution_path'] ?? '';
            unset($_request_data['__execution_path']);

            // init dispatcher.
            pirogue_import_load('pirogue/dispatcher');
            pirogue_dispatcher_init(sprintf('%s://%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST']), $_request_path, $_request_data);

            // clean reqeust data.
            $_data = $_request_data;
            $_path_parts = explode('/', $_request_path);
            array_walk($_path_parts, fn($str) => preg_replace('/^_/','', $str));
            
            $_module = array_shift($_path_parts);            
            $_page = array_shift($_path_parts);            
            $_page = empty($_page) ? 'index' : $_page;

            if ( empty($_module) ){
                $_view = $_page;
            } else {
                $_view = implode('/', [$_module, $_page]);
            }

            $_path = implode('/', $_path_parts);

            pirogue_import_load('pirogue/view');
            pirogue_import_load('pirogue/cdn');
            pirogue_import_load('site/html');
            
            pirogue_view_init(_PIROGUE_PATH_VIEW);    
            pirogue_cdn_init([$GLOBALS['.pirogue.dispatcher.address']]);

            // initialize view variables:
            site_html_create();
            
            // load requested page.
            $_view_file = _pirogue_view_get_path($_view);
            $GLOBALS['.request_page'] = $_view;
            $GLOBALS['.request_path'] = $_path;
            $GLOBALS['.request_data'] = $_request_data;
            

            if ( empty($_view_file) ) {
                $GLOBALS['.request_page'] = '_error-404';
                $GLOBALS['.request_path'] = '';
                $GLOBALS['.request_data'] = [
                    'view_file' => $_view_file,
                    'view' => $_view,
                    'path' => $_path,
                    'data' => $_data,
                ];            
                $_view_file = _pirogue_view_get_path('_error-404');
                
            }

            $GLOBALS['view_data'] = [];
            ob_start();
            require $_view_file;
            $GLOBALS['.html.body.content'] = ob_get_clean();

            
        }
        catch (Throwable $_throwable) {
            $_view_file = _pirogue_view_get_path('_error-500');
            $GLOBALS['.request_page'] = '_error-500';
            $GLOBALS['.request_path'] = '';
            $GLOBALS['.request_data'] = [
                'exception' => $_throwable,
                'view' => $_view,
                'path' => $_path,
                'data' => $_data,
            ];            

            $GLOBALS['view_data'] = [];
            ob_start();
            require $_view_file;
            $GLOBALS['.html.body.content'] = ob_get_clean();        
        }


        // load conent into page template
        $_view = _pirogue_view_get_path('_page');
        
        ob_start();
        require $_view;
        $_html_page = ob_get_clean();


        // send page content and exit.
        while ( 0 < ob_get_level() ) {
            ob_get_clean();
        }
        _pirogue_dispatcher_send($_html_page);
        _pirogue_dispatcher_exit();
    } catch (Throwable $_throwable) {
        while ( 0 < ob_get_level() ) {
            ob_get_clean();
        }
        printf('%s (%s:%d)', $_throwable->getMessage(),$_throwable->getFile(), $_throwable->getLine());
        echo '<pre>';
        var_dump($_throwable);
        echo '</pre>';
    }
?>