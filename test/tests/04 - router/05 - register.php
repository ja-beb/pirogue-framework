<?php

/**
 * Testing pirogue\dispatcher\router\register()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));

$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);

pirogue_test_execute('register()', function () {
    router\register('example-controller', 'index', 'GET');
    return 1 == count($GLOBALS['._pirogue.dispatcher.router.call_stack']) ? '' : 'did not register controller.';
});

pirogue_test_execute('register()', function () {
    $count = router\register('example-controller', 'index', 'POST');
    return count($GLOBALS['._pirogue.dispatcher.router.call_stack']) == $count ? '' : 'return valud does not match.';
});
router\_dispose();
