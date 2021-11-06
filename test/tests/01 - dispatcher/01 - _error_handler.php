<?php

/**
 * Testing pirogue\_dispatcher_error_handler().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_dispatcher_error_handler;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

pirogue_test_execute('pirogue\_dispatcher_error_handler(): call directly', function () {
    try {
        _dispatcher_error_handler(42, 'my custom error', __FILE__, __LINE__);
        return 'Error not thrown.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\_dispatcher_error_handler(): register and throw exception', function () {
    try {
        set_error_handler('pirogue\_dispatcher_error_handler');
        throw new Exception("thrown exception");
        return 'Error not thrown.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\_dispatcher_error_handler(): register and throw error', function () {
    try {
        set_error_handler('pirogue\_dispatcher_error_handler');
        trigger_error('My triggered error');
        return 'Error not thrown.';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\_dispatcher_error_handler(): register and case error', function () {
    try {
        set_error_handler('pirogue\_dispatcher_error_handler');
        1 / 0;
        return 'Error not thrown.';
    } catch (Throwable) {
        return '';
    }
});
