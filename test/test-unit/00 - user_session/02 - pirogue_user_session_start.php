<?php

/**
 * Testing pirogue_user_session_start().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'user_session.php']);

// test pirogue_user_session_start() - check for session when there should be none.
pirogue_test_execute('_pirogue_user_session_start(): null session', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    return null != pirogue_user_session_current()
        ? 'User session contains values before being set.'
        : '';
});

// test pirogue_user_session_start() - check for session set.
pirogue_test_execute('_pirogue_user_session_start(): session set', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    _pirogue_user_session_start($GLOBALS['._pirogue-testing.user_session.user']);
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] == $GLOBALS['._pirogue-testing.user_session.user']
        ? ''
        : 'User session not properly set.';
});
