<?php

/**
 * Testing controller_import_get_path()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_import_init;
use function pirogue\controller_import_get_path;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller_import.php']));

pirogue_test_execute("controller_import_get_path(): invalid controller", function () {
    controller_import_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $controller = controller_import_get_path(['invalid-module']);
    return '' == $controller  ? '' : 'function returned invalid controller path.';
});


pirogue_test_execute("controller_import_get_path(): valid controller", function () {
    controller_import_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $controller = controller_import_get_path(['testing']);
    require $controller;
});
