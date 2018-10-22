<?php

/**
 * Main dispatcher for JSON content.
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */


function _json_send($data, bool $hasError){
    header('Content-Type: application/json', true);
    sprout\dispatcher_send( json_encode([
        'hasError' => $hasError,
        'payload' => $data
    ]));
}


require '../sprout/dispatcher.inc';

try{
    
    /* Declare page varaiables */
    $GLOBALS['._import_path'] = '';
    $GLOBALS['._view_path'] = __DIR__;
    $GLOBALS['._view_path'] = "{$GLOBALS['._view_path']}\_json\%s.inc";

    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);

    // Get view file
    $_execution_view = sprintf($GLOBALS['._view_path'], $_request_path);
    $_json_data = ['hasError' => false, 'payload' => null ];

    if ( false == file_exists($_execution_view) ){
        // File not found error
        http_response_code(404);
        _json_send( "Unable to find requested resource: {$_request_path}", true);
    }else{
        // Load requested file
        _json_send( require $_execution_view, false );
    }

}catch(Exception $_exception){
    http_response_code(500);
    _json_send( $_exception->getMessage(), true );
}catch(Error $_exception){
    http_response_code(500);
    _json_send( $_exception->getMessage(), true );
}

header('Content-Type: application/json', true);
echo json_encode($_json_data);
exit();

