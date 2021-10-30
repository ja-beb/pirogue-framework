<?php

/**
 * Testing build_path()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller\_init;
use function pirogue\controller\build_path;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

pirogue_test_execute("controller_current(): valid controller", function () {
    _init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $path = build_path(['example-controller', 'index']);
    return '/pirogue/controllers/example-controller.php' == $path ? '' : sprintf('invalid controller path returned "%s".', $path);
});

pirogue_test_execute("controller_current(): invalid controller", function () {
    _init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']));
    $path = build_path(['missing-controller', 'index']);
    return '' == $path ? '' : sprintf('invalid controller path returned "%s".', $path);
});
