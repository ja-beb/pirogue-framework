<?php

/**
 * Testing for pirogue\_session_init() && pirogue\_session_dispose().
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_session_init;
use function pirogue\_session_dispose;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.session.name'] = '._pirogue-testing.session';
_session_init($GLOBALS['._pirogue-testing.session.name']);

pirogue_test_execute('_init(): initialize ._pirogue.session.user.label', function () {
    if (false == array_key_exists('._pirogue.session.name', $GLOBALS)) {
        return '00 - var "._pirogue.session.user.label" not initialized.';
    } elseif ($GLOBALS['._pirogue-testing.session.name'] != $GLOBALS['._pirogue.session.name']) {
        return '01 - var "._pirogue.session.user.label" not properly set.';
    } else {
        return '';
    }
});

_session_dispose();

pirogue_test_execute('_dispose(): $GLOBALS[\'._pirogue.session.user.label\']', function () {
    return array_key_exists('._pirogue.session.name', $GLOBALS) ? 'value still set.' : '';
});

// clean up testin environment.
unset($_SESSION);
