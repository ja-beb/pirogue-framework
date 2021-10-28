<?php

/**
 * Testing controller_current()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_init;
use function pirogue\controller_current;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

pirogue_test_execute("controller_current()", function () {
    $name = 'testing';
    controller_init($name);
    return controller_current() == $name ? '' : 'invalid controller name.';
});
