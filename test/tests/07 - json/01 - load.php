<?php

/**
 * Test pirogue\view\json\load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\view\json;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view', 'json.php']));

$GLOBALS['._pirogue-testing.view.html.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', 'json', '%s.php']);

json\_init($GLOBALS['._pirogue-testing.view.json.path_pattern']);
pirogue_test_execute('view_get_path', function () {
    try {
        $view = json\load('invalid-file');
        return 'loaded invalid view';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('view_get_path', function () {
    $view = json\load('test');
    return '/pirogue/view/test.pjson' == $view ? '' : sprintf('unable to load view: "%s"', $view);
});

json\_dispose();
