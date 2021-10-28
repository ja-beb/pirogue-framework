<?php

/**
 * Test import_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\import_init;

define('_PIROGUE_TESTING_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']));
require_once(sprintf(_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue/import'));

pirogue_test_execute("import_init():", function () {
    import_init(_PIROGUE_TESTING_PATH_INCLUDE);
    return _PIROGUE_TESTING_PATH_INCLUDE == $GLOBALS['._pirogue.import.pattern'] ? '' : "invalid value for \$GLOBALS['._pirogue.import.pattern']";
});
