<?php

/**
 * Test import_load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\import_init;
use function pirogue\import_load;

if (!defined('_PIROGUE_TESTING_PATH_INCLUDE')) {
    define('_PIROGUE_TESTING_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']));
}
require_once(sprintf(_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue/import'));

pirogue_test_execute('import_load(): invalid file', function () {
    try {
        import_init(_PIROGUE_TESTING_PATH_INCLUDE);
        import_load('file-not-found');
        return 'Loaded invalid library file.';
    } catch (ErrorException) {
        return '';
    }
});

pirogue_test_execute('import_load(): valid file', function () {
    import_init(_PIROGUE_TESTING_PATH_INCLUDE);
    import_load('pirogue/cdn');
});
