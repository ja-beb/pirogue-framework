<?php

/**
 * Testing register()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller\_init;
use function pirogue\controller\_dispose;
use function pirogue\controller\register;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

_init('');
pirogue_test_execute("register()", function () {
    register('controller #1');
    return 1 == count($GLOBALS['._pirogue.controller_import.call_stack']) ? '' : 'did not register controller.';
});

pirogue_test_execute("register()", function () {
    $count = register('controller #2');
    return count($GLOBALS['._pirogue.controller_import.call_stack']) == $count ? '' : 'return valud does not match.';
});
_dispose();
