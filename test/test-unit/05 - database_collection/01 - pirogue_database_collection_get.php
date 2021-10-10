<?php

/**
 * Testing pirogue_database_collection_get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'database_collection.php']));

function _pirogue_test_database_collection_query(?mysqli $database_connection)
{
    $_sql_results = mysqli_query($database_connection, 'SELECT COUNT(id) AS user_count FROM users ORDER BY username');
    $_sql_data = mysqli_fetch_assoc($_sql_results);
    mysqli_free_result($_sql_results);
    return array_key_exists('user_count', $_sql_data) ? [] : ['unable to get count of website.users rows.'];
}

// test pirogue_database_collection_init(): invalid directory
pirogue_test_execute('pirogue_database_collection_init: invalid config directory', function () {
    try {
        pirogue_database_collection_init(
            implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_CONFIG, 'config-invalid']),
            'website'
        );
        return [ 'Invalid database config directory accepted.' ];
    } catch (InvalidArgumentException) {
        return [];
    }
});

// test pirogue_database_collection_get: invalid label
pirogue_test_execute('pirogue_database_collection_get(): invalid label', function () {
    try {
        pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
        _pirogue_test_database_collection_query(pirogue_database_collection_get('no-such-connection'));
        return [ 'Invalid database connection returned.' ];
    } catch (ErrorException) {
        return [];
    }
});

// test pirogue_database_collection_get: valid label
pirogue_test_execute('pirogue_database_collection_get(): valid label', function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    _pirogue_test_database_collection_query(pirogue_database_collection_get('website'));
});

// test pirogue_database_collection_get: default label
pirogue_test_execute('pirogue_database_collection_get(): default label', function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    _pirogue_test_database_collection_query(pirogue_database_collection_get());
});
