<?php

/**
 * Testing _pirogue_error_handler().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'error_handler.php']));

pirogue_test_execute('_pirogue_error_handler()', function () {
    try {
        _pirogue_error_handler(42, 'my custom error', __FILE__, __LINE__);
        return 'Error not thrown.';
    } catch (Throwable) {
        return '';
    }
});
