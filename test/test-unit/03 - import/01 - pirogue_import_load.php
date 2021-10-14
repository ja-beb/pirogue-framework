<?php

/**
 * Test pirogue_import_load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'import.php']));

pirogue_test_execute('pirogue_import_load(): invalid file', function () {
    try {
        pirogue_import_init(_PIROGUE_TESTING_PATH_INCLUDE);
        pirogue_import_load('file-not-found');
        return 'Loaded invalid library file.';
    } catch (ErrorException) {
        return '';
    }
});

pirogue_test_execute('pirogue_import_load(): valid file', function () {
    pirogue_import_init(_PIROGUE_TESTING_PATH_INCLUDE);
    pirogue_import_load('pirogue/cdn');
});
