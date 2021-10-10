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

// test pirogue_user_session_remove()
pirogue_test_execute('_pirogue_user_session_set ', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    $errors = [];
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        if ($value != pirogue_user_session_remove($key)) {
            array_push($errors, "00 - returned incorrect value for '{$key}'.");
        }

        if (array_key_exists($key, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            array_push($errors, "01 - variable '{$key}' not removed.");
        }
    }
    return $errors;
});
