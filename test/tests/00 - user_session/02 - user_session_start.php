<?php

/**
 * Testing pirogue\_user_session_start().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_start;
use function pirogue\user_session_init;
use function pirogue\user_session_current;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

// test _user_session_start() - check for session when there should be none.
pirogue_test_execute('_user_session_start(): null session', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    return null != user_session_current()
        ? 'User session contains values before being set.'
        : '';
});

// test _user_session_start() - check for session set.
pirogue_test_execute('_user_session_start(): session set', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    _user_session_start($GLOBALS['._pirogue-testing.user_session.user']);
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] == $GLOBALS['._pirogue-testing.user_session.user']
        ? ''
        : 'User session not properly set.';
});
