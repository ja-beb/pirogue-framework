<?php

/**
 * Test pirogue\_import_init() and pirogue\_import_dispose()
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_import_init;
use function pirogue\_import_dispose;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'import.php']);

$GLOBALS['._pirogue-testing.import.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']);
_import_init($GLOBALS['._pirogue-testing.import.path_pattern']);

pirogue_test_execute("pirogue\_import_init()", fn() => $GLOBALS['._pirogue-testing.import.path_pattern'] == $GLOBALS['._pirogue.import.path_pattern']
    ? ''
    : sprintf('invalid value returned: expected "%s" recieved "%s"', $GLOBALS['._pirogue-testing.import.path_pattern'], $GLOBALS['._pirogue.import.path_pattern']));

_import_dispose();
pirogue_test_execute("pirogue\_import_dispose():", fn() => array_key_exists('._pirogue.import.path_pattern', $GLOBALS) ? 'variables not unset.' : '');
