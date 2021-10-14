<?php

/**
 * Test pirogue_import_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

define('_PIROGUE_TESTING_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'import.php']));

pirogue_test_execute('pirogue_import_init(): invalid directory', function () {
    try {
        pirogue_import_init('/invalid/path');
        return 'Set library to invalid file.';
    } catch (InvalidArgumentException) {
        return '';
    }
});

pirogue_test_execute(
    'pirogue_import_init(): valid directory',
    fn() => pirogue_import_init(_PIROGUE_TESTING_PATH_INCLUDE)
);

pirogue_test_execute("pirogue_import_init(): \$GLOBALS['._pirogue.import.path']", function () {
    pirogue_import_init(_PIROGUE_TESTING_PATH_INCLUDE);
    return _PIROGUE_TESTING_PATH_INCLUDE == $GLOBALS['._pirogue.import.path'] ? '' : "invalid value for \$GLOBALS['._pirogue.import.path']";
});
