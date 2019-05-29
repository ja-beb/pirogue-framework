<?php
use function org\location_types_fetch;
use function org\location_types_list;
use function org\location_types_lookup;
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
    $_results = location_types_list(_get_database());
} elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = location_types_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_types_fetch(_get_database(), $matches[1]);
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_types_fetch(_get_database(), $matches[1]);
} elseif (preg_match('/^label\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_types_lookup(_get_database(), 'label=?', [
        $matches[1]
    ]);
    $_results = (0 == count($_results)) ? null : $_results;
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return array_merge([
        [
            'id',
            'label'
        ]
    ], $_results);
}

