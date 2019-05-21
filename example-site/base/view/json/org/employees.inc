<?php
use function org\employees_list;
use function org\employees_fetch;
use function pirogue\database_collection_get;
use function pirogue\import;
use function org\employees_lookup;

import('org');

function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.view.path']) {
    $_results = employees_list(_get_database());    
} elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = employees_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^employee-number\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_lookup(_get_database(), 'employee_number=?', [
        $matches[1]
    ]);
    $_results = ( 0 == count($_results) ) ? null : $_results;
} elseif (preg_match('/^email[-address]?\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_lookup(_get_database(), 'email_address=?', [
        $matches[1]
    ]);
    $_results = ( 0 == count($_results) ) ? null : $_results;
} 

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return $_results;
}

