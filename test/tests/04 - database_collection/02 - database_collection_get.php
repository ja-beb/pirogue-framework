<?php

/**
 * Testing database_collection_get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\database_collection_get;
use function pirogue\database_collection_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

database_collection_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

function _pirogue_test_database_collection_query(?mysqli $database_connection)
{
    $_sql_results = mysqli_query($database_connection, 'SELECT COUNT(id) AS user_count FROM users ORDER BY username');
    $_sql_data = mysqli_fetch_assoc($_sql_results);
    mysqli_free_result($_sql_results);
    return array_key_exists('user_count', $_sql_data) ? '' : 'unable to get count of website.users rows.';
}

pirogue_test_execute('database_collection_get(): invalid label', function () {
    try {
        _pirogue_test_database_collection_query(database_collection_get('no-such-connection'));
        return 'Invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('database_collection_get(): valid label', function () {
    _pirogue_test_database_collection_query(database_collection_get('website'));
});

// test database_collection_get: default label
pirogue_test_execute('database_collection_get(): default label', function () {
    _pirogue_test_database_collection_query(database_collection_get());
});

// test database_collection_get: default label
pirogue_test_execute('pirogue_database_collection_get(): website-invalid', function () {
    try {
        _pirogue_test_database_collection_query(database_collection_get('website-invalid'));
        return 'invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});
