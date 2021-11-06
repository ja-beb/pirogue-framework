<?php

/**
 * Testing pirogue\_view_json_init() and pirogue\_view_json_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_view_json_init;
use function pirogue\_view_json_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view_json.php']));

$GLOBALS['._pirogue-testing.view.json.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', 'json', '%s.php']);
$GLOBALS['._pirogue-testing.view.json.view_fragment'] = ['content' => ''];

_view_json_init($GLOBALS['._pirogue-testing.view.json.path_pattern']);
pirogue_test_execute('pirogue\_view_json_init()', fn() => $GLOBALS['._pirogue-testing.view.json.path_pattern'] == $GLOBALS['._pirogue.view.json.path_pattern'] ? '' : 'invalid value for .path_pattern.');

_view_json_dispose();
pirogue_test_execute('pirogue\_view_json_dispose()', fn() => array_key_exists('._pirogue.view.json.path_pattern', $GLOBALS) ? 'invalid view pattern.' : '');
