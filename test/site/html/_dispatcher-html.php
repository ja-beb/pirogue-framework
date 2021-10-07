<?php 
    // bootstrap page - start necessary php functionality.
    ob_start();
    session_id() || session_start();
    
    // define constants.
    define('_PIROGUE_PATH', '/var/www');
    define('_PIROGUE_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'include']));
    define('_PIROGUE_PATH_VIEW', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'view']));
    define('_PIROGUE_PATH_CONFIG', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'config']));

    function _dispatcher_clear_buffer() {
        while ( 0 < ob_get_level() ) {
            ob_get_clean();
        }
    }

    // load autoloader.
    require implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH_INCLUDE, 'pirogue', 'import.php']);

    try {
        pirogue_import_init(_PIROGUE_PATH_INCLUDE);

        // import libraries.            
        pirogue_import_load('pirogue/error_handler');
        pirogue_import_load('pirogue/dispatcher');
        pirogue_import_load('pirogue/view');
        pirogue_import_load('pirogue/cdn');
        pirogue_import_load('pirogue/site_notices');
        pirogue_import_load('pirogue/database_collection');
        pirogue_import_load('site/html');

        // register error handler.
        set_error_handler('_pirogue_error_handler');

        try {

            // parse request data.
            $GLOBALS['.request_data'] = $_GET;
            unset($GLOBALS['.request_data']['__execution_path']);
            $GLOBALS['._dispatcher_path'] = explode('/', $_GET['__execution_path'] ?? '');
            array_walk(
                $GLOBALS['._dispatcher_path'],
                fn($str, $key) => $GLOBALS['._dispatcher_path'][$key] = preg_replace('/^_/', '', $str)
            );

            // init dispatcher, cdn and view libraries.
            pirogue_dispatcher_init(
                sprintf('%s://%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST']), 
                implode('/', $GLOBALS['._dispatcher_path']), 
                $GLOBALS['.request_data']
            );            
            pirogue_cdn_init([
                sprintf('%s://%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'])
            ]);
            pirogue_view_init(_PIROGUE_PATH_VIEW);
            pirogue_site_notices_init('._pirogue-testing.site_notices');
            pirogue_database_collection_init(_PIROGUE_PATH_CONFIG, 'website');

            // build request components.
            $GLOBALS['.request_path'] = $GLOBALS['._dispatcher_path'];
            $GLOBALS['.request_module'] = array_shift($GLOBALS['.request_path']);
            $GLOBALS['.request_page'] = array_shift($GLOBALS['.request_path']) ?? 'index';            

            // initialize html view variables:
            site_html_create();
            ob_start();
            $_path = empty($GLOBALS['.request_module']) ? $GLOBALS['.request_page'] : implode('/', [$GLOBALS['.request_module'], $GLOBALS['.request_page']]);
            require _pirogue_view_get_path($_path) ?? _pirogue_view_get_path('_error/404');
            $GLOBALS['.html.body.content'] = ob_get_clean();

        }
        catch (Throwable $_throwable) {
            $GLOBALS['.request_data'] = [
                'exception' => $_throwable
            ];

            // load error view.
            site_html_create();
            ob_start();
            require _pirogue_view_get_path('_error/500');
            $GLOBALS['.html.body.content'] = ob_get_clean();        
        }

        // load conent into page template
        ob_start();
        require _pirogue_view_get_path('_page');
        $_html_page = ob_get_clean();

        // send page content and exit.
        _dispatcher_clear_buffer();
        _pirogue_dispatcher_send($_html_page);
        _pirogue_dispatcher_exit();
    } catch (Throwable $_throwable) {
        _dispatcher_clear_buffer();
        printf('%s (%s:%d)', $_throwable->getMessage(),$_throwable->getFile(), $_throwable->getLine());
        echo '<pre>';
        var_dump($_throwable);
        echo '</pre>';
    }
?>