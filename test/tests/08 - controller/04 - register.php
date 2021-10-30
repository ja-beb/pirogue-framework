<?php

/**
 * Testing register()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\controller;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

controller\_init('');
pirogue_test_execute('register()', function () {
    controller\register('controller #1');
    return 1 == count($GLOBALS['._pirogue.controller_import.call_stack']) ? '' : 'did not register controller.';
});

pirogue_test_execute('register()', function () {
    $count = controller\register('controller #2');
    return count($GLOBALS['._pirogue.controller_import.call_stack']) == $count ? '' : 'return valud does not match.';
});
controller\_dispose();
