<?php

/**
 * Testing pirogue\user_session_current().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session_current;
use function pirogue\user_session_init;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

// test user_session_current() - check for emtpy initialized session
pirogue_test_execute('user_session_current(): verify that session is null', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    return null == user_session_current() ? '' : 'User session contains values before being set.';
});

// test user_session_current() - check for session after set manually.
pirogue_test_execute('user_session_current(): verify that session exists', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $GLOBALS['._pirogue-testing.user_session.user'];
    return match (user_session_current()) {
        null => 'User data not set.',
        !$GLOBALS['._pirogue-testing.user_session.user'] => 'Invalid user data returned.',
        default => ''
    };
});
