<?php

/**
 * Main dispatcher for JSON content.
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */

/* Bootsrap */

/* Declare page varaiables */


try{
    
    $GLOBALS['._import_path'] = '';
    $GLOBALS['._view_path'] = __DIR__;
    $GLOBALS['._view_path'] = "{$GLOBALS['._view_path']}\_content\json\%s.inc";

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Get view file
    $_execution_view = sprintf($GLOBALS['._view_path'], $_request_path);
    $_json_data = ['hasError' => false, 'payload' => null ];

    // Check for file:
    if ( false == file_exists($_execution_view) ){
        http_response_code(404);
        $_json_data['hasError'] = true;
        $_json_data['payload'] = 'Unable to find requested resource';
    }else{
        $_json_data['payload'] = require($_execution_view);
    }

}catch(Exception $_exception){
    http_response_code(500);
    $_json_data['hasError'] = true;
    $_json_data['payload'] = $_exception->getMessage();
}catch(Error $_exception){
    http_response_code(500);
    $_json_data['hasError'] = true;
    $_json_data['payload'] = $_exception->getMessage();
}

header('Content-Type: application/json', true);
echo json_encode($_json_data);
exit();

