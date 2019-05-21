<?php
use function org\position_list;
use function org\position_lookup;
use function org\position_fetch;
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
    $_results = position_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = position_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = position_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^label\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = position_lookup(_get_database(), 'label=?', [
        $matches[1]
    ]);
    $_results = ( 0 == count($_results) ) ? null : $_results;
} elseif (preg_match('/^(.+)\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $filter = null;
    switch ($matches[1]) {
        case 'payrate':
            $filter = 'payrate_id=?';
            break;

        case 'division':
            $filter = 'division_id=?';
            break;
    }

    if ($filter) {
        $_results = position_lookup(_get_database(), $filter, [
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

