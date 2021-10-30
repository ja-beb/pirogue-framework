<?php

/**
 * Testing current_controller()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller\current_controller;
use function pirogue\controller\_init;
use function pirogue\controller\_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

_init('');
pirogue_test_execute("current()", function () {
    $name = $GLOBALS['._pirogue.controller_import.call_stack'][0] ?? '';
    return current_controller() == $name ? '' : 'invalid controller name.';
});
_dispose();
