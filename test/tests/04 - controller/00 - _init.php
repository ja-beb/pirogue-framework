<?php

/**
 * Testing pirogue\dispatcher\controller\_init() and pirogue\dispatcher\controller\_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\controller;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'controller.php']));

$GLOBALS['._pirogue-testing.controller.namespace'] = 'site\example_controller';
controller\_init($GLOBALS['._pirogue-testing.controller.namespace']);

pirogue_test_execute('_init()', function() {
    if (!array_key_exists('._pirogue.controller.namespace', $GLOBALS)) {
        return 'variable ._pirogue.controller.namespace not set';
    } elseif ($GLOBALS['._pirogue.dispatcher.router.path_format'] == $GLOBALS['._pirogue-testing.controller.namespace']) {
        return '';
    } else {
        return 'invalid value set to ._pirogue.controller.namespace.';
    }
});

controller\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.controller.namespace', $GLOBALS)  ? 'variable not cleared.' : '');
