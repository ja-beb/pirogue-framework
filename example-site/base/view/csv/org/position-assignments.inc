<?php
use function org\position_assignments_fetch;
use function org\position_assignments_list;
use function org\position_assignments_lookup;
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
    $_results = position_assignments_list(_get_database());
} elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = position_assignments_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = position_assignments_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = position_assignments_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^(.+)\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $filter = null;
    switch ($matches[1]) {
        case 'employee':
        case 'employee-id':
            $filter = 'employee_id=?';
            break;

        case 'postion':
        case 'postion-id':
            $filter = 'postion_id=?';
            break;
    }

    if ($filter) {
        $_results = position_assignments_lookup(_get_database(), $filter, [
            $matches[2]
        ]);
        $_results = (0 == count($_results)) ? null : $_results;
    }
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return array_merge([
        [
            'id',
            'employee id',
            'position id',
            'location id',
            'department id',
            'date start',
            'date end',
            'pay grade id'
        ]
    ], $_results);
}

