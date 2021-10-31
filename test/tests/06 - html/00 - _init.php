<?php

/**
 * Testing pirogue\view\html\_init() and pirogue\view\html\_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\view\html;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view', 'html.php']));

$GLOBALS['._pirogue-testing.view.html.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']);
$GLOBALS['._pirogue-testing.view.html.view_fragment'] = ['content' => ''];

html\_init($GLOBALS['._pirogue-testing.view.html.path_pattern']);
pirogue_test_execute('_init()', fn() => $GLOBALS['._pirogue-testing.view.html.path_pattern'] == $GLOBALS['._pirogue.view.html.path_pattern'] ? '' : 'invalid value for .path_pattern.');

html\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.view.html.path_pattern', $GLOBALS) ? 'invalid view pattern.' : '');
