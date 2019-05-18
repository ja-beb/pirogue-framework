<?php 

use function pirogue\database_collection_get;
use function org\division_fetch;
use function pirogue\import;

import('org');

$_database_connection = database_collection_get('example-site');

$_path = trim($GLOBALS['.pirogue.view.path']);

$_matches= [];

if ( '' === $_path ){
    return org\org_list($_database_connection, 'divisions');
}elseif ( preg_match('/^find\/(.*)\/(.*)/', $_path, $_matches) ){
    return org\org_find($_database_connection, 'divisions', $_matches[1], $_matches[2]);
}else{
    return org\org_fetch($_database_connection, 'divisions', $_path);
}
 