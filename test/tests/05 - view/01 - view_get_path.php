<?php

/**
 * Test view_get_path().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\view_init;
use function pirogue\view_get_path;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view.php']));

view_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']));

pirogue_test_execute('view_get_path: invalid file', function () {
    $view = view_get_path('invalid-file');
    return '' == $view ? '' : sprintf('unable to load view: "%s"', $view);
});

pirogue_test_execute('view_get_path: valid file', function () {
    $view = view_get_path('test');
    return '' == $view ? sprintf('unable to load view: "%s"', $view) : '';
});

pirogue_test_execute('view_get_path: ../config/invalid.phtml', function () {
    $view = view_get_path('../config/invalid');
    return '' == $view ? sprintf('able to load view: "%s"', $view) : '';
});
