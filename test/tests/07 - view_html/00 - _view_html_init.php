<?php

/**
 * Testing pirogue\_view_html_init() and pirogue\_view_html_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_view_html_init;
use function pirogue\_view_html_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view_html.php']));

$GLOBALS['._pirogue-testing.view_html.path_pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', 'json', '%s.phtml']);
$GLOBALS['._pirogue-testing.view_html.view_fragment'] = ['content' => ''];

_view_html_init($GLOBALS['._pirogue-testing.view_html.path_pattern']);
pirogue_test_execute('pirogue\_view_html_init()', fn() => $GLOBALS['._pirogue-testing.view_html.path_pattern'] == $GLOBALS['._pirogue.view_html.path_pattern'] ? '' : 'invalid value for .path_pattern.');

_view_html_dispose();
pirogue_test_execute('pirogue\_view_html_dispose()', fn() => array_key_exists('._pirogue.view_html.path_pattern', $GLOBALS) ? 'invalid view pattern.' : '');
