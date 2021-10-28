<?php

/**
 * Test html_view_load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\html_view_init;
use function pirogue\html_view_load;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'html_view.php']));

html_view_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']));

pirogue_test_execute('view_get_path: invalid file', function () {
    try {
        $view = html_view_load('invalid-file');
        return 'loaded invalid view';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('view_get_path: valid file', function () {
    $view = html_view_load('test');
    return '/pirogue/view/test.phtml' == ($view['body']['content'] ?? '') ? '' : sprintf('unable to load view: "%s"', $view);
});
