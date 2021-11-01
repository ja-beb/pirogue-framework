<?php

/**
 * Testing pirogue\dispatcher\controller\has_access()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\controller;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'controller.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', 'example-controller.php']));

$GLOBALS['._pirogue-testing.controller.namespace'] = 'example_controller';
controller\_init($GLOBALS['._pirogue-testing.controller.namespace']);

pirogue_test_execute('has_access()', function() {
    if (controller\has_access(null)) {
        return 'has_access returned wrong value';
    } elseif (!controller\has_access(1)) {
        return 'has_access returned wrong value';
    } else {
        return '';
    }
});

controller\_dispose();
