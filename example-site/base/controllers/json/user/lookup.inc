<?php
namespace controllers\json\user\lookup;

use function pirogue\database_collection_get;
use function pirogue\import;

/**
 *
 * @param string $path
 * @param array $request
 * @return array
 */
function route_status(string $path, array $request): array{
    return ['status' => 'awake' ];
}


/**
 *
 * @param string $path
 * @param array $request
 * @return array
 */
function route_details(string $path, array $request): array{
    import('org');
    
    $db = database_collection_get('website');
    $data = \org\employee_fetch($db, _ORG_EMPLOYEE_FETCH_FILTER_ID, $path);    
    if ( empty($data ) ){
        http_response_code(404);        
    }
    return $data;
}

