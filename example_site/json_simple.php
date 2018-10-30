<?php

/**
 * Main dispatcher for JSON content.
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */


// translate path: Module/[route]
// testing/users/info.json
// site/notices.json
// users/info/sbourg.json
// testing/user_info.json

// Load module
// Call namespace\route($_execution_path, $_GET);


require '../sprout/import.inc';

__import(realpath('include'));
import('sprout/dispatcher');
import('sprout/json');

// build request [headers => [], etag => '', content => '']


// Check caching using unique id
// If cached, force cached
// Else build

try{
    /* Parse request */
    $_request_data = $_GET;
    $_request_path = $_request_data['__execution_path'] ?? '';
    unset($_request_data['__execution_path']);
    
    
    $_file = "_json/{$_request_path}.inc";
    if ( file_exists($_file) ){
        json_send(require $_file, true);
    }else{
    }
    
}catch(Exception $_exception){
    http_response_code(500);
    json_send( $_exception->getMessage(), true );
}catch(Error $_exception){
    http_response_code(500);
    json_send( $_exception->getMessage(), true );
}


http_response_code(404);
json_send( "Unable to find requested resource: {$_request_path}", true);

exit();

