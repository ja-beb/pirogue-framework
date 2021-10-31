<?php

/**
 * Testing pirogue\database\_open().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database.php']));

// set up testing environment
database\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');


pirogue_test_execute('_open(): valid label', fn () => database\_open('website') instanceof mysqli ? '' : 'invalid return type');
pirogue_test_execute('_open(): bad connection info', function () {
    try {
        $databaase = database\_open('website-error');
        return 'able to open database connection.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('_open(): non-existant connection', function () {
    try {
        $databaase = database\_open('website-invalid');
        return 'able to open database connection.';
    } catch (Throwable) {
        return '';
    }
});

database\_dispose();
