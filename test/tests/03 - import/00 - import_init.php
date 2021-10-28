<?php

/**
 * Test import_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\import_init;

define('_PIROGUE_TESTING_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'import.php']));

pirogue_test_execute('import_init(): invalid directory', function () {
    try {
        import_init('/invalid/path');
        return 'Set library to invalid file.';
    } catch (InvalidArgumentException) {
        return '';
    }
});

pirogue_test_execute(
    'import_init(): valid directory',
    fn() => import_init(_PIROGUE_TESTING_PATH_INCLUDE)
);

pirogue_test_execute("import_init(): \$GLOBALS['._pirogue.import.path']", function () {
    import_init(_PIROGUE_TESTING_PATH_INCLUDE);
    return _PIROGUE_TESTING_PATH_INCLUDE == $GLOBALS['._pirogue.import.path'] ? '' : "invalid value for \$GLOBALS['._pirogue.import.path']";
});
