<?php

/**
 * Testing build_path()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\controller;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

controller\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
pirogue_test_execute('controller_current(): valid controller', function () {
    $path = controller\build_path(['example-controller', 'index']);
    controller\_dispose();
    return '/pirogue/controllers/example-controller.php' == $path ? '' : sprintf('invalid controller path returned "%s".', $path);
});

pirogue_test_execute('controller_current(): invalid controller', function () {
    controller\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $path = controller\build_path(['missing-controller', 'index']);
    return '' == $path ? '' : sprintf('invalid controller path returned "%s".', $path);
});
controller\_dispose();
