<?php

/**
 * Test pirogue\import\load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\import;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'import.php']);

import\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', '%s.php']));
pirogue_test_execute('load(): invalid file', function () {
    try {
        import\load('file-not-found');
        return 'Loaded invalid library file.';
    } catch (ErrorException) {
        return '';
    }
});

pirogue_test_execute('load(): valid file', fn() => import\load('pirogue/dispatcher/servers'));
import\_dispose();
