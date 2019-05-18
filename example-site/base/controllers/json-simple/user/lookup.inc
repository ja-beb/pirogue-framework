<?php
namespace controllers\json\user\lookup;

use function pirogue\database_collection_get;
use function pirogue\import;

return ['status'];

import('org');
$db = database_collection_get('website');
$data = \org\employee_fetch($db, _ORG_EMPLOYEE_FETCH_FILTER_ID, $path);    
if ( empty($data ) ){
    http_response_code(404);        
}
return $data;
