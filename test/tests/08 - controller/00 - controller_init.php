<?php

/**
 * Testing controller_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

pirogue_test_execute("controller_init()", function () {
    $name = 'testing';
    controller_init($name);
    return $GLOBALS['._pirogue.controller.name'] == $name ? '' : 'invalid controller name.';
});
