<?php 

use function pirogue\database_collection_get;
use function org\department_list;
use function org\department_fetch;
use function pirogue\import;

import('org');

$_database_connection = database_collection_get('example-site');


return ( '' === trim($GLOBALS['.pirogue.view.path']) ) ? department_list($_database_connection) : department_fetch($_database_connection, intval($GLOBALS['.pirogue.view.path']));