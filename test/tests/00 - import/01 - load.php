<?php

/**
 * Test pirogue\import_load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_import_init;
use function pirogue\_import_dispose;
use function pirogue\import_load;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'import.php']);

_import_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']));
pirogue_test_execute('import_load(): invalid file', function () {
    try {
        import_load('file-not-found');
        return 'Loaded invalid library file.';
    } catch (ErrorException) {
        return '';
    }
});

pirogue_test_execute('import_load(): valid file', fn() => import_load('pirogue/dispatcher'));
_import_dispose();
