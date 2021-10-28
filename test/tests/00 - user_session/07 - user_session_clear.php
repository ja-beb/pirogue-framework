<?php

/**
 * Test user_session_clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session_clear;
use function pirogue\user_session_init;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

pirogue_test_execute('user_session_clear() - verify return value.', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    // clear and check if return equals set values.
    return $GLOBALS['._pirogue-testing.user_session.list'] != user_session_clear()
        ?  'Returned variables do not match initial state.'
        : '';
});

pirogue_test_execute('user_session_clear(): value not cleard.', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    return empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])
        ? 'Registered variables did not cleared.'
        : '';
});
