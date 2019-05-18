<?php 

use function pirogue\database_collection_get;
use function org\position_list;
use function org\position_fetch;
use function pirogue\import;

import('org');

$_database_connection = database_collection_get('example-site');


return ( '' === trim($GLOBALS['.pirogue.view.path']) ) ? position_list($_database_connection) : position_fetch($_database_connection, intval($GLOBALS['.pirogue.view.path']));