<?php

/**
 * Testing \pirogue\database\mysqli\_open().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

// set up testing environment
mysqli\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

pirogue_test_execute('_open(): invalid connection', function () {
    try {
        $connection = mysqli\_open(hostname: 'invalid-hostname', username: 'invalid-user');
        return null == $connection ? '' : 'able to open invalid connection';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('_open(): valid connection', function () {
    try {
        $connection = mysqli\_open(
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
mysqli\_dispose();
