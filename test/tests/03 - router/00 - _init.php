<?php

/**
 * Testing pirogue\dispatcher\controller\_init() and pirogue\dispatcher\router\_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));

$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);

pirogue_test_execute('_init()', fn() => $GLOBALS['._pirogue.dispatcher.router.path_format'] == $GLOBALS['._pirogue-testing.dispatcher.router.path_format'] ? '' : 'invalid controller path format.');

router\_dispose();
pirogue_test_execute('_init()', fn() => array_key_exists('._pirogue.dispatcher.router.path_format', $GLOBALS)  ? 'invalid controller path format.' : '');
