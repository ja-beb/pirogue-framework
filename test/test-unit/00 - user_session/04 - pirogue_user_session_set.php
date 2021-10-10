<?php

/**
 * Test _pirogue_user_session_set().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', '_PirogueTestObject.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'user_session.php']);

// test _pirogue_user_session_set()
pirogue_test_execute('_pirogue_user_session_set ', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    array_walk($GLOBALS['._pirogue-testing.user_session.list'], fn(mixed $value, string $key) => pirogue_user_session_set($key, $value));
    return _user_session_compare($GLOBALS['._pirogue-testing.user_session.list'], $_SESSION[$GLOBALS['._pirogue.user_session.label_data']], []);
});
