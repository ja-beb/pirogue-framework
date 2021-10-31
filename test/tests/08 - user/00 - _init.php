<?php

/**
 * Testing for _init() && _dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\user;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'user.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.session.user.label'] = '.testin-user-session';
user\_init($GLOBALS['._pirogue-testing.session.user.label']);

pirogue_test_execute('_init(): initialize ._pirogue.session.user.label', function () {
    if (false == array_key_exists('._pirogue.session.user.label', $GLOBALS)) {
        return '00 - var "._pirogue.session.user.label" not initialized.';
    } elseif ($GLOBALS['._pirogue-testing.session.user.label'] != $GLOBALS['._pirogue.session.user.label']) {
        return '01 - var "._pirogue.session.user.label" not properly set.';
    } else {
        return '';
    }
});

// test _init() - user data is initialized to a null value.
pirogue_test_execute('_init(): user data', function () {
    if (false == array_key_exists($GLOBALS['._pirogue-testing.session.user.label'], $_SESSION)) {
        return sprintf('00 - session variable "%s" not initialized.', $GLOBALS['._pirogue-testing.session.user.label']);
    } elseif (null != $_SESSION[$GLOBALS['._pirogue-testing.session.user.label']]) {
        return sprintf(
            '01 - session variable "%s" not properly set (type=%s).',
            $GLOBALS['._pirogue.session.user.label'],
            gettype($_SESSION[$GLOBALS['._pirogue.session.user.label']])
        );
    } else {
        return '';
    }
});

user\_dispose();

pirogue_test_execute('_dispose(): $GLOBALS[\'._pirogue.session.user.label\']', function () {
    return array_key_exists('._pirogue.session.user.label', $GLOBALS) ? 'value still set.' : '';
});

// clean up testin environment.
unset($_SESSION);
