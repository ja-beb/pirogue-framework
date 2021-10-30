<?php

/**
 * Testing get_connection().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\database_collection\get_connection;
use function pirogue\database_collection\_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

function _pirogue_test_database_collection_query(?mysqli $database_connection)
{
    $_sql_results = mysqli_query($database_connection, 'SELECT COUNT(id) AS user_count FROM users ORDER BY username');
    $_sql_data = mysqli_fetch_assoc($_sql_results);
    mysqli_free_result($_sql_results);
    return array_key_exists('user_count', $_sql_data) ? '' : 'unable to get count of website.users rows.';
}

pirogue_test_execute('get_connection(): invalid label', function () {
    try {
        _pirogue_test_database_collection_query(get_connection('no-such-connection'));
        return 'Invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('get_connection(): valid label', function () {
    _pirogue_test_database_collection_query(get_connection('website'));
});

// test get_connection: default label
pirogue_test_execute('get_connection(): default label', function () {
    _pirogue_test_database_collection_query(get_connection());
});

// test get_connection: default label
pirogue_test_execute('pirogue_get_connection(): website-invalid', function () {
    try {
        _pirogue_test_database_collection_query(get_connection('website-invalid'));
        return 'invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});
