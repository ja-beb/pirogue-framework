<?php

/**
 * Test load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\view_html\_init;
use function pirogue\view_html\load;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view_html.php']));

_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']));

pirogue_test_execute('view_get_path: invalid file', function () {
    try {
        $view = load('invalid-file');
        return 'loaded invalid view';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('view_get_path: valid file', function () {
    $view = load('test');
    return '/pirogue/view/test.phtml' == ($view['body']['content'] ?? '') ? '' : sprintf('unable to load view: "%s"', $view);
});
