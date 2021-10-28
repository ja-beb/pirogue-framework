<?php

/**
 * Testing database_collection_get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\database_collection_get;
use function pirogue\database_collection_init;

define('_PIROGUE_TESTING_PATH_CONFIG', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config']));

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

function _pirogue_test_database_collection_query(?mysqli $database_connection)
{
    $_sql_results = mysqli_query($database_connection, 'SELECT COUNT(id) AS user_count FROM users ORDER BY username');
    $_sql_data = mysqli_fetch_assoc($_sql_results);
    mysqli_free_result($_sql_results);
    return array_key_exists('user_count', $_sql_data) ? '' : 'unable to get count of website.users rows.';
}

pirogue_test_execute('pirogue_database_collection_init: invalid config directory', function () {
    try {
        database_collection_init(
            implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_CONFIG, 'config-invalid']),
            'website'
        );
        return 'Invalid database config directory accepted.';
    } catch (InvalidArgumentException) {
        return '';
    }
});

pirogue_test_execute('database_collection_get(): invalid label', function () {
    try {
        database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
        _pirogue_test_database_collection_query(database_collection_get('no-such-connection'));
        return 'Invalid database connection returned.';
    } catch (ErrorException) {
        return '';
    }
});

pirogue_test_execute('database_collection_get(): valid label', function () {
    database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    _pirogue_test_database_collection_query(database_collection_get('website'));
});

// test database_collection_get: default label
pirogue_test_execute('database_collection_get(): default label', function () {
    database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    _pirogue_test_database_collection_query(database_collection_get());
});

// test database_collection_get: default label
pirogue_test_execute('pirogue_database_collection_get(): website-invalid', function () {
    try {
        database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
        _pirogue_test_database_collection_query(database_collection_get('website-invalid'));
        return 'invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});
