<?php

/**
 * Testing _init() and _finalize()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\view_html\_init;
use function pirogue\view_html\_finalize;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view_html.php']));

$GLOBALS['._pirogue-testing.view_html.pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']);
_init($GLOBALS['._pirogue-testing.view_html.pattern']);
pirogue_test_execute("_init()", function () {
    return $GLOBALS['._pirogue-testing.view_html.pattern'] == $GLOBALS['._pirogue.view_html.pattern']
        ? ''
        : 'invalid view pattern.';
});

_finalize();
pirogue_test_execute("_finalize()", function () {
    return array_key_exists('._pirogue.view_html.pattern', $GLOBALS)
        ? 'invalid view pattern.'
        : '';
});
