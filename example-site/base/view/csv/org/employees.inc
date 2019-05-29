<?php
use function org\employees_list;
use function org\employees_fetch;
use function pirogue\database_collection_get;
use function pirogue\import;
use function org\employees_lookup;

import('org');

function _get_database()
{
    return database_collection_get('example-site');
}

$_results = null;
$matches = [];

if ('' === $GLOBALS['.pirogue.view.path']) {
    $_results = employees_list(_get_database());
} elseif ('list' === $GLOBALS['.pirogue.view.path']) {
    $_results = employees_list(_get_database());
} elseif (preg_match('/^(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^id\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_fetch(_get_database(), intval($matches[1]));
} elseif (preg_match('/^employee-number\/(\d+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_lookup(_get_database(), 'employee_number=?', [
        $matches[1]
    ]);
    $_results = (0 == count($_results)) ? null : $_results;
} elseif (preg_match('/^email[-address]?\/(.+)$/', $GLOBALS['.pirogue.view.path'], $matches)) {
    $_results = employees_lookup(_get_database(), 'email_address=?', [
        $matches[1]
    ]);
    $_results = (0 == count($_results)) ? null : $_results;
}
if (null === $_results) {
    http_response_code(404);
    return null;
} else {
    $_data = [
        [
            'id' => 'id',
            'employee_number'=> 'employee number',
            'name_given' => 'name given',
            'name_surname' => 'name surname',
            'name_middle' => 'name middle',
            'name_generation_qualifier' => 'name generation qualifier',
            'name_title' => 'name title',
            'gender' => 'gender',
            'ssn' => 'ssn',
            'email_address' => 'email address',
            'date_of_birth' => 'date of birth',
            'date_start' => 'date start',
            'date_end' => 'date end'
        ]
    ];
    foreach ($_results as $_row) {
        array_push($_data, [
            'id' => $_row['id'],
            'employee number' => $_row['employee_number'],
            'name given' => $_row['name_given'],
            'name surname' => $_row['name_surname'],
            'name middle' => $_row['name_middle'],
            'name generation qualifier' => $_row['name_generation_qualifier'],
            'name title' => $_row['name_title'],
            'gender' => $_row['gender'],
            'ssn' => $_row['ssn'],
            'email address' => $_row['email_address'],
            'date_of_birth' => (null == $_row['date_of_birth']) ? null : $_row['date_of_birth']->format('Y-m-d'),
            'date_start' => (null == $_row['date_start']) ? null : $_row['date_start']->format('Y-m-d'),
            'date_end' => (null == $_row['date_end']) ? null : $_row['date_end']->format('Y-m-d')
        ]);
    }
    return $_data;
}

