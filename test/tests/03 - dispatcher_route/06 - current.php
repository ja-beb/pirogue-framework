<?php

/**
 * Testing pirogue\dispatcher\router\current()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));

$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);

pirogue_test_execute('current()', function () {
    $controller = ['example-controller', 'index', 'GET'];
    array_unshift($GLOBALS['._pirogue.dispatcher.router.call_stack'], $controller);
    return router\current() == $controller ? '' : 'invalid controller name.';
});
router\_dispose();
