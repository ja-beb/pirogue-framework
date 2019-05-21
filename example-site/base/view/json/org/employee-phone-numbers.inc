<?php
use function org\employee_phone_numbers_fetch;
use function org\employee_phone_numbers_list;
use function org\employee_phone_numbers_lookup;
use function pirogue\database_collection_get;
use function pirogue\import;

import('org');

function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.view.path']) {
    $_results = employee_phone_numbers_list(_get_database());
} elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = employee_phone_numbers_list(_get_database());
} elseif (preg_match('/^(.+)\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $filter = null;
    switch ($matches[1]) {
        case 'employee':
        case 'employee-id':
            $filter = 'employee_id=?';
            break;

        case 'type':
        case 'type-id':
            $filter = 'type_id=?';
            break;
    }

    if ($filter) {
        $_results = employee_phone_numbers_lookup(_get_database(), $filter, [
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

