<?php 

use function org\division_list;
use function org\division_fetch;
use function org\division_find;
use function pirogue\database_collection_get;
use function pirogue\import;
use function org\division_lookup;

import('org');


function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.view.path']) {
    $_results = division_list(_get_database(), 'divisions');
} elseif (is_int($GLOBALS['.pirogue.view.path'])) {
    $_results = division_find(_get_database(), intval($GLOBALS['.pirogue.view.path']));
} elseif (preg_match('/^(.+)\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $filter = null;
    switch ($matches[1]) {
        case 'id':
            $filter = 'id=?';
            break;
            
        case 'label':
            $filter = 'label=?';
            break;
    }
    
    if ($filter) {
        $_results = division_lookup(_get_database(), $filter, [
            $matches[2]
        ]);
    }
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return $_results;
}

