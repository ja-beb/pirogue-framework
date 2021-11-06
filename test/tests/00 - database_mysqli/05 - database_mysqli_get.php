<?php

/**
 * Testing pirogue\database_mysqli_get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_database_mysqli_init;
use function pirogue\_database_mysqli_dispose;
use function pirogue\database_mysqli_get;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_mysqli.php']));

// set up testing environment
_database_mysqli_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

function _pirogue_test_mysqli_query(?mysqli $database_connection)
{
    $_sql_results = mysqli_query($database_connection, 'SELECT COUNT(id) AS user_count FROM users ORDER BY username');
    $_sql_data = mysqli_fetch_assoc($_sql_results);
    mysqli_free_result($_sql_results);
    return array_key_exists('user_count', $_sql_data) ? '' : 'unable to get count of website.users rows.';
}

pirogue_test_execute('pirogue\database_mysqli_get(): invalid label', function () {
    try {
        _pirogue_test_mysqli_query(database_mysqli_get('no-such-connection'));
        return 'Invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\database_mysqli_get(): valid label', fn () => _pirogue_test_mysqli_query(database_mysqli_get('website')));
pirogue_test_execute('pirogue\database_mysqli_get(): default label', fn () => _pirogue_test_mysqli_query(database_mysqli_get()));
pirogue_test_execute('pirogue\database_mysqli_get(): website-invalid', function () {
    try {
        _pirogue_test_mysqli_query(database_mysqli_get('website-invalid'));
        return 'invalid database connection returned.';
    } catch (Throwable) {
        return '';
    }
});
pirogue_test_execute('pirogue\database_mysqli_get(): website-invalid', fn() => null == ($GLOBALS['._pirogue.database_mysqli.connections']['website']) ? 'connections not registered.' : '');

// clean up testing environment
_database_mysqli_dispose();
