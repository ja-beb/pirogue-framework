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
} elseif (is_int($GLOBALS['.pirogue.view.path'])) {
    $_results = location_types_fetch(_get_database(), intval($GLOBALS['.pirogue.view.path']));
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
        $_results = location_types_lookup(_get_database(), $filter, [
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

