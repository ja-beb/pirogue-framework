<?php

/**
 * Testing current()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\controller;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

controller\_init('');
pirogue_test_execute('current()', function () {
    $name = $GLOBALS['._pirogue.controller_import.call_stack'][0] ?? '';
    return controller\current() == $name ? '' : 'invalid controller name.';
});
controller\_dispose();
