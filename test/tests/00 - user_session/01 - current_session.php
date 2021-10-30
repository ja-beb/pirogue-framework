<?php

/**
 * Testing current_session().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session\current_session;
use function pirogue\user_session\_init;
use function pirogue\user_session\_dispose;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

$_SESSION = [];
_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

pirogue_test_execute('current_session(): verify that session is null', function () {
    return null == current_session() ? '' : 'User session contains values before being set.';
});

// test current_session() - check for session after set manually.
pirogue_test_execute('current_session(): verify that session exists', function () {
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $GLOBALS['._pirogue-testing.user_session.user'];
    return match (current_session()) {
        null => 'User data not set.',
        !$GLOBALS['._pirogue-testing.user_session.user'] => 'Invalid user data returned.',
        default => ''
    };
});
_dispose();
