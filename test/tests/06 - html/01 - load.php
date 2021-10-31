<?php

/**
 * Test pirogue\view\html\load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\view\html;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view', 'html.php']));

$GLOBALS['._pirogue-testing.view.html.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']);

html\_init($GLOBALS['._pirogue-testing.view.html.path_pattern']);
pirogue_test_execute('view_get_path', function () {
    try {
        $view = html\load('invalid-file');
        return 'loaded invalid view';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('view_get_path', function () {
    $view = html\load('test');
    return '/pirogue/view/test.phtml' == $view ? '' : sprintf('unable to load view: "%s"', $view);
});

html\_dispose();
