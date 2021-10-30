<?php

/**
 * Test _init() and _finalize
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\import\_init;
use function pirogue\import\_finalize;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'import.php']);

pirogue_test_execute("imp_initort_init()", function () {
    $GLOBALS['._pirogue-testing.import.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']);
    _init($GLOBALS['._pirogue-testing.import.path_pattern']);
        return $GLOBALS['._pirogue-testing.import.path_pattern'] == $GLOBALS['._pirogue.import.path_pattern']
    ? ''
    : sprintf('invalid value returned: expected "%s" recieved "%s"', $GLOBALS['._pirogue-testing.import.path_pattern'], $GLOBALS['._pirogue.import.path_pattern']);
});

pirogue_test_execute("import_init():", function () {
    _finalize();
    return array_key_exists('._pirogue.import.path_pattern', $GLOBALS) ? 'variables not unset.' : '';
});
