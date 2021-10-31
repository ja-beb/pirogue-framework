<?php

/**
 * Testing _start().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\user_session;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

$_SESSION = [];
user_session\_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

pirogue_test_execute('_start(): null session', function () {
    return null != $_SESSION[$GLOBALS['._pirogue.user_session.label_user']]
        ? 'User session contains values before being set.'
        : '';
});

// test _user_session_start() - check for session set.
pirogue_test_execute('_user_session_start(): session set', function () {
    user_session\_start($GLOBALS['._pirogue-testing.user_session.user']);
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] == $GLOBALS['._pirogue-testing.user_session.user']
        ? ''
        : 'User session not properly set.';
});

user_session\_dispose();
unset($_SESSION);
