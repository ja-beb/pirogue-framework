<?php

/**
 * Testing pirogue\dispatcher\router\_build_path()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));

$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);

pirogue_test_execute('_build_path(): valid controller', function () {
    $path = router\_build_path(['example-controller', 'index']);
    return '/pirogue/controller/example-controller.php' == $path ? '' : sprintf('invalid controller path returned "%s".', $path);
});

pirogue_test_execute('_build_path(): invalid controller', function () {
    $path = router\_build_path(['invalid-controller', 'index']);
    return '' == $path ? '' : sprintf('invalid controller path returned "%s".', $path);
});

router\_dispose();
