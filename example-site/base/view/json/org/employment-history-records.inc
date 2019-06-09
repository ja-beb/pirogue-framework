<?php
use function org\employment_history_records_fetch;
use function org\employment_history_records_list;
use function org\employment_history_records_lookup;
use function pirogue\database_collection_get;
use function pirogue\import;

import('org');

function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.request.path']) {
    $_results = employment_history_records_list(_get_database());    
} elseif ('list' === $GLOBALS['.pirogue.request.path']) {
    $_results = employment_history_records_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = employment_history_records_fetch(_get_database(), $matches[1]);
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = employment_history_records_fetch(_get_database(), $matches[1]);
} elseif (preg_match('/^employee[-id]?\/(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = employment_history_records_lookup(_get_database(), 'employee_id=?', [
        $matches[1]
    ]);
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return $_results;
}

