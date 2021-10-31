<?php

/**
 * Testing \pirogue\database\mysqli\get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

// set up testing environment
mysqli\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

function _pirogue_test_mysqli_query(?\mysqli $database_connection)
{
    $_sql_results = mysqli_query($database_connection, 'SELECT COUNT(id) AS user_count FROM users ORDER BY username');
    $_sql_data = mysqli_fetch_assoc($_sql_results);
    mysqli_free_result($_sql_results);
    return array_key_exists('user_count', $_sql_data) ? '' : 'unable to get count of website.users rows.';
}

pirogue_test_execute('get(): invalid label', function () {
    try {
        _pirogue_test_mysqli_query(mysqli\get('no-such-connection'));
        return 'Invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('get(): valid label', fn () => _pirogue_test_mysqli_query(mysqli\get('website')));
pirogue_test_execute('get(): default label', fn () => _pirogue_test_mysqli_query(mysqli\get()));
pirogue_test_execute('pirogue_get(): website-invalid', function () {
    try {
        _pirogue_test_mysqli_query(mysqli\get('website-invalid'));
        return 'invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});
pirogue_test_execute('pirogue_get(): website-invalid', fn() => empty($GLOBALS['._pirogue.database.mysqli.connections']) ? 'connections not registered.' : '');

// clean up testing environment
mysqli\_dispose();
