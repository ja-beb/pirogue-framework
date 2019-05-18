<?php 

use function pirogue\database_collection_get;
use function org\division_list;
use function org\division_fetch;
use function pirogue\import;

import('org');

$_database_connection = database_collection_get('example-site');
return ( '' === trim($GLOBALS['.pirogue.view.path']) ) ? division_list($_database_connection) : division_fetch($_database_connection, intval($GLOBALS['.pirogue.view.path']));