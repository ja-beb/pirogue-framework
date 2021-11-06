<?php

/**
 * Testing for pirogue\session\_init() && pirogue\session\_dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.session.name'] = '._pirogue-testing.session';
session\_init($GLOBALS['._pirogue-testing.session.name']);

pirogue_test_execute('_init(): initialize ._pirogue.session.user.label', function () {
    if (false == array_key_exists('._pirogue.session.name', $GLOBALS)) {
        return '00 - var "._pirogue.session.user.label" not initialized.';
    } elseif ($GLOBALS['._pirogue-testing.session.name'] != $GLOBALS['._pirogue.session.name']) {
        return '01 - var "._pirogue.session.user.label" not properly set.';
    } else {
        return '';
    }
});

session\_dispose();

pirogue_test_execute('_dispose(): $GLOBALS[\'._pirogue.session.user.label\']', function () {
    return array_key_exists('._pirogue.session.name', $GLOBALS) ? 'value still set.' : '';
});

// clean up testin environment.
unset($_SESSION);
