<?php

/**
 * Testing pirogue\view\json\_init() and pirogue\view\json\_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\view\json;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view', 'json.php']));

$GLOBALS['._pirogue-testing.view.html.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', 'json', '%s.php']);
$GLOBALS['._pirogue-testing.view.json.view_fragment'] = ['content' => ''];

json\_init($GLOBALS['._pirogue-testing.view.json.path_pattern']);
pirogue_test_execute('_init()', fn() => $GLOBALS['._pirogue-testing.view.json.path_pattern'] == $GLOBALS['._pirogue.view.json.path_pattern'] ? '' : 'invalid value for .path_pattern.');

json\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.view.json.path_pattern', $GLOBALS) ? 'invalid view pattern.' : '');
