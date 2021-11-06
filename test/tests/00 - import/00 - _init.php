<?php

/**
 * Test _init() and _dispose
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\import;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'import.php']);

$GLOBALS['._pirogue-testing.import.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']);
import\_init($GLOBALS['._pirogue-testing.import.path_pattern']);

pirogue_test_execute("imp_initort_init()", fn() => $GLOBALS['._pirogue-testing.import.path_pattern'] == $GLOBALS['._pirogue.import.path_pattern']
    ? ''
    : sprintf('invalid value returned: expected "%s" recieved "%s"', $GLOBALS['._pirogue-testing.import.path_pattern'], $GLOBALS['._pirogue.import.path_pattern']));

import\_dispose();
pirogue_test_execute("import_init():", fn() => array_key_exists('._pirogue.import.path_pattern', $GLOBALS) ? 'variables not unset.' : '');