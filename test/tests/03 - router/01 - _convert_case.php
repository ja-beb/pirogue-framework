<?php

/**
 * Testing pirogue\dispatcher\router\_convert_case()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));
$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);
pirogue_test_execute('_convert_case(): testing_index-GET', fn() => router\_convert_case('testing_index-GET') == 'testing_index_GET' ? '' : 'invalid function name.');
router\_dispose();
