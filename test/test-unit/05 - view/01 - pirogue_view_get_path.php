<?php

/**
 * Test dispatcher library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'view.php']));

pirogue_view_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']));

pirogue_test_execute('_pirogue_view_get_path: invalid file', function () {
    $view = pirogue_view_get_path('invalid-file');
    return '' == $view ? '' : sprintf('unable to load view: "%s"', $view);
});

pirogue_test_execute('_pirogue_view_get_path: valid file', function () {
    $view = pirogue_view_get_path('test');
    return '' == $view ? sprintf('unable to load view: "%s"', $view) : '';
});

pirogue_test_execute('_pirogue_view_get_path: ../config/invalid.phtml', function () {
    $view = pirogue_view_get_path('../config/invalid');
    return '' == $view ? sprintf('able to load view: "%s"', $view) : '';
});
