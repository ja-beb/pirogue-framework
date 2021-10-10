<?php

/**
 * Test pirogue_user_session_remove().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'user_session.php']);

pirogue_test_execute('pirogue_user_session_remove(): return values', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        if ($value != pirogue_user_session_remove($key)) {
            return "returned incorrect value for '{$key}'.";
        }
    }
    return '';
});

pirogue_test_execute('pirogue_user_session_remove(): ', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        pirogue_user_session_remove($key);
        if (array_key_exists($key, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            return "variable '{$key}' not removed.";
        }
    }
    return '';
});
