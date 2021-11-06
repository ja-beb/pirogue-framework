<?php

/**
 * Test pirogue\view_html_load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_view_html_init;
use function pirogue\_view_html_dispose;
use function pirogue\view_html_load;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view_html.php']));

$GLOBALS['._pirogue-testing.view_html.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', 'html', '%s.phtml']);
$GLOBALS['._pirogue-testing.view_html.view_fragment'] = ['content' => ''];

_view_html_init($GLOBALS['._pirogue-testing.view_html.path_pattern']);
pirogue_test_execute('pirogue\view_html_load(): invalid view', function () {
    try {
        $view = view_html_load('invalid-file');
        return 'loaded invalid view';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\view_html_load(): valid view', function () {
    $view = view_html_load('test');
    return '/pirogue/view/html/test.phtml' == $view ? '' : sprintf('unable to load view: "%s"', $view);
});

_view_html_dispose();
