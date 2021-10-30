<?php

/**
 * Test import().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\import\_init;
use function pirogue\import\_finalize;
use function pirogue\import\import;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'import.php']);

_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']));
pirogue_test_execute('import_load(): invalid file', function () {
    try {
        import('file-not-found');
        return 'Loaded invalid library file.';
    } catch (ErrorException) {
        return '';
    }
});

pirogue_test_execute('import_load(): valid file', function () {
    import('pirogue/cdn');
});
_finalize();
