<?php
use function org\location_list;
use function org\location_lookup;
use function org\location_fetch;
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
    $_results = location_list(_get_database());
} elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = location_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^label\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_lookup(_get_database(), 'label=?', [
        $matches[1]
    ]);
    $_results = (0 == count($_results)) ? null : $_results;
} elseif (preg_match('/^type-code\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = location_lookup(_get_database(), 'type_code=?', [
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
            'label',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'zipcode',
            'type code'
        ]
    ], $_results);
}

