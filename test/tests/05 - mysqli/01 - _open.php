<?php

/**
 * Testing pirogue\database\mysqli\_open().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

// set up testing environment
mysqli\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

pirogue_test_execute('_open(): valid label', fn () => mysqli\_open('website') instanceof mysqli ? '' : 'invalid return type');
pirogue_test_execute('_open(): bad connection info', function () {
    try {
        $databaase = mysqli\_open('website-error');
        return 'able to open database connection.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('_open(): non-existant connection', function () {
    try {
        $databaase = mysqli\_open('website-invalid');
        return 'able to open database connection.';
    } catch (Throwable) {
        return '';
    }
});

mysqli\_dispose();
