<?php

/**
 * Testing _init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller\_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

$GLOBALS['._pirogue-testing.controller_import.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']);
_init($GLOBALS['._pirogue-testing.controller_import.path_format']);
pirogue_test_execute("_init()", function () {
    $GLOBALS['._pirogue.controller_import.path_format'] == $GLOBALS['._pirogue-testing.controller_import.path_format'] ? '' : 'invalid controller path format.';
});
use function pirogue\controller\_dispose;
