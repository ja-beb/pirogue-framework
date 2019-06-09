<?php
use function site\applications_roles_list;
use function site\applications_roles_lookup;
use function site\applications_roles_fetch;
use function pirogue\database_collection_get;
use function pirogue\import;

import('site');

function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.request.path']) {
    $_results = applications_roles_list(_get_database());
}elseif ('list' === $GLOBALS['.pirogue.request.path']) {
    $_results = applications_roles_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {    
    $_results = applications_roles_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = applications_roles_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^application\/(\d+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = applications_roles_lookup(_get_database(), 'application_id=?', [
        $matches[1]
    ]);
    $_results = $_results[0] ?? null;
} elseif (preg_match('/^application\/(.+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = applications_roles_lookup(_get_database(), 'application_name=?', [
        $matches[1]
    ]);
    $_results = $_results[0] ?? null;
} elseif (preg_match('/^name\/(.+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = applications_roles_lookup(_get_database(), 'role_name=?', [
        $matches[1]
    ]);
    $_results = $_results[0] ?? null;
} elseif (preg_match('/^(.+)$/', $GLOBALS['.pirogue.request.path'], $matches)) {
    $_results = applications_roles_lookup(_get_database(), 'role_name=?', [
        $matches[1]
    ]);
    $_results = $_results[0] ?? null;
}

if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    return $_results;
}

