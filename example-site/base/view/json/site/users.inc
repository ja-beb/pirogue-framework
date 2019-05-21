<?php
use function site\user_list;
use function site\user_lookup;
use function site\user_fetch;
use function pirogue\database_collection_get;
use function pirogue\import;

import('site');

function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.view.path']) {
    $_results = user_list(_get_database());
}elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = user_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {    
    $_results = user_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = user_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^email\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = user_lookup(_get_database(), 'email=?', [
        $matches[1]
    ]);
} elseif (preg_match('/^(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = user_lookup(_get_database(), 'email=?', [
        $matches[1]
    ]);
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return $_results;
}

