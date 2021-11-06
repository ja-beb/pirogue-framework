<?php

/**
 * Testing \pirogue\_database_mysqli_open().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_database_mysqli_init;
use function pirogue\_database_mysqli_dispose;
use function pirogue\_database_mysqli_open;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_mysqli.php']));

// set up testing environment
_database_mysqli_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

pirogue_test_execute('pirogue\_database_mysqli_open(): invalid connection', function () {
    try {
        $connection = _database_mysqli_open(hostname: 'invalid-hostname', username: 'invalid-user');
        return null == $connection ? '' : 'able to open invalid connection';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\_database_mysqli_open(): valid connection', function () {
    try {
        $connection = _database_mysqli_open(
            hostname: 'pirogue-database',
            username: 'website-user',
            password: 'website-password',
            database: 'website',
        );
        return null == $connection ? 'unnable to open valid connection' : '';
    } catch (Throwable) {
        return 'unable to open valid connection';
    }
});

// clean up testing environment
_database_mysqli_dispose();
