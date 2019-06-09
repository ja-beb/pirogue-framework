<?php
use function org\position_pay_grades_fetch;
use function org\position_pay_grades_list;
use function org\position_pay_grades_lookup;
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
    $_results = position_pay_grades_list(_get_database());
} elseif ('list' === $GLOBALS['.pirogue.request.path']) {
    $_results = position_pay_grades_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = position_pay_grades_fetch(_get_database(), $matches[1]);
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = position_pay_grades_fetch(_get_database(), $matches[1]);
} elseif (preg_match('/^label\/(.+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = position_pay_grades_lookup(_get_database(), 'label=?', [
        $matches[1]
    ]);
    $_results = (0 == count($_results)) ? null : $_results[0];
} elseif (preg_match('/^position[-id]?\/(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = position_pay_grades_lookup(_get_database(), 'position_id=?', [
        $matches[1]
    ]);
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return array_merge([
        [
            'id',
            'position',
            'label'
        ]
    ], $_results);
}

