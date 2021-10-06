<?php 

    ob_start();
    
    // define constants.
    define('_PIROGUE_PATH', '/var/www');
    define('_PIROGUE_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'include']));
    define('_PIROGUE_PATH_VIEW', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'view']));
    define('_PIROGUE_PATH_CONFIG', implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH, 'config']));

    require implode(DIRECTORY_SEPARATOR, [_PIROGUE_PATH_INCLUDE, 'pirogue', 'import.php']);

    try {
        pirogue_import_init(_PIROGUE_PATH_INCLUDE);
        pirogue_import_load('pirogue/dispatcher');
        
        
        $_request_data = $_GET;
        $_request_path = $_request_data['__execution_path'] ?? '';
        unset($_request_data['__execution_path']);

        $_data = $_request_data;
        
        $_path_parts = explode('/', $_request_path);
        array_walk($_path_parts, fn($str) => preg_replace('/^_/','', $str));
        $_page = array_pop($_path_parts);
        $_page = empty($_page) ? 'index' : $_page;
        $_path = implode('/', $_path_parts);
        
        pirogue_import_load('pirogue/view');
        pirogue_view_init(_PIROGUE_PATH_VIEW);    

        
        $_view = _pirogue_view_get_path($_page);
        $_view_data = [
            'request' => [ 'path' => $_path,  'data' => $_request_data ]
        ];

        if ( empty($_view) ) {
            $_view = _pirogue_view_get_path('_error-400');
            $_view_data = [
                'request' => [ 'path' => '_error-400',  'data' => [] ],
                'request' => [ 'path' => $_path,  'data' => $_request_data ]
            ];
        }

        ob_start();
        require $_view;
        $_content = ob_get_clean();

        
        $_view = _pirogue_view_get_path('_page');
        $_view_data = [
            'page' => [
                'body' => $_content
            ]
        ];
        ob_start();
        require $_view;
        $_content = ob_get_clean();


        _pirogue_dispatcher_send($_content);
        _pirogue_dispatcher_exit();
    } catch (Throwable $_throwable) {
        echo $_throwable->getMessage();
    }
?>