<?php

/**
 * Test pirogue\view_json_load().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_view_json_init;
use function pirogue\_view_json_dispose;
use function pirogue\view_json_load;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view_json.php']));

$GLOBALS['._pirogue-testing.view.json.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', 'json', '%s.php']);
$GLOBALS['._pirogue-testing.view.json.view_fragment'] = ['content' => ''];

_view_json_init($GLOBALS['._pirogue-testing.view.json.path_pattern']);
pirogue_test_execute('pirogue\view_json_load(): invalid view', function () {
    try {
        $view = view_json_load('invalid-file');
        return 'loaded invalid view';
    } catch (Throwable) {
        return '';
    }
});

pirogue_test_execute('pirogue\view_json_load(): valid view', function () {
    $view = view_json_load('test');
    return ['file' => '/pirogue/view/json/test.php'] == $view ? '' : sprintf('unable to load view: "%s"', $view);
});

_view_json_dispose();
