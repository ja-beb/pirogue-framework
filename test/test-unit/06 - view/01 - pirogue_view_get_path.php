<?php

/**
 * Test dispatcher library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'view.php']));

pirogue_test_execute('_pirogue_view_get_path: invalid file', function () {
    $view = pirogue_view_get_path('invalid-file');
    return '' == $view ? [] : [ 'Loaded invalid view.'] ;
});

pirogue_test_execute('_pirogue_view_get_path: valid file', function () {
    $view = pirogue_view_get_path('test');
    return '' == $view ? [ 'Unable to load view.'] : [];
});
