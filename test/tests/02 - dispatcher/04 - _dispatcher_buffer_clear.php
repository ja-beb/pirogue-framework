<?php

/**
 * Testing _dispatcher_buffer_clear()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_buffer_clear;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

pirogue_test_execute('dispatcher_current_url()', function () {
    for ($i = 0; $i < 5; $i++) {
        ob_start();
        printf('THIS IS BUFFER #%d', $i);
    }
    _dispatcher_buffer_clear();

    $buffer = ob_get_clean();
    return empty($buffer) ? '' : 'buffer not cleared.';
});
