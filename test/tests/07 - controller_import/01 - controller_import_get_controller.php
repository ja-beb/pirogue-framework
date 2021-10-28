<?php

/**
 * Testing controller_import_get_controller()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_import_init;
use function pirogue\controller_import_get_controller;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller_import.php']));

pirogue_test_execute("controller_import_get_controller(): invalid controller", function () {
    controller_import_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $controller = controller_import_get_controller(['invalid-module']);
    return '' == $controller  ? '' : 'function returned invalid controller path.';
});


pirogue_test_execute("controller_import_get_controller(): valid controller", function () {
    controller_import_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $controller = controller_import_get_controller(['testing']);
    require $controller;
    $path = 'one/two';
    return testing_index_get(explode('/', $path), []) == $path
        ? ''
        : 'invalid function directory.';
});
