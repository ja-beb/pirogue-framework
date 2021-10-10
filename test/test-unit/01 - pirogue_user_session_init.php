<?php

/**
 * Test the user session functions.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', '_PirogueTestObject.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'user_session.php']);

// test pirogue_user_session_init() - ._pirogue.user_session.label_user
pirogue_test_execute('pirogue_user_session_init: initialize ._pirogue.user_session.label_user', function () {
    _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    if (false == array_key_exists('._pirogue.user_session.label_user', $GLOBALS)) {
        return ['00 - var "._pirogue.user_session.label_user" not initialized.'];
    } elseif (sprintf('%s_user', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_user']) {
        return ['01 - var "._pirogue.user_session.label_user" not properly set.'];
    } else {
        return [];
    }
});

// test pirogue_user_session_init() - ._pirogue.user_session.label_data
pirogue_test_execute('pirogue_user_session_init: initialize ._pirogue.user_session.label_data', function () {
    _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    if (false == array_key_exists('._pirogue.user_session.label_data', $GLOBALS)) {
        return ['00 - var "._pirogue.user_session.label_data" not initialized.'];
    } elseif (sprintf('%s_data', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_data']) {
        return ['01 - var "._pirogue.user_session.label_data" not properly set.'];
    } else {
        return [];
    }
});

// test pirogue_user_session_init() - check user data
pirogue_test_execute('pirogue_user_session_init: user data', function () {
    _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $index = sprintf('%s_user', _PIROGUE_TESTING_USER_SESSION_LABEL);
    if (false == array_key_exists($index, $_SESSION)) {
        return ["00 - session variable '{$index}' not initialized."];
    } elseif (null != $_SESSION[$index]) {
        return [sprintf(
            '01 - session variable "%s" not properly set (type=%s).',
            $GLOBALS['._pirogue.user_session.label_user'],
            gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_user']])
        )];
    } else {
        return [];
    }
});

// test pirogue_user_session_init() - check data
pirogue_test_execute('pirogue_user_session_init: user data', function () {
    _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $index = sprintf('%s_data', _PIROGUE_TESTING_USER_SESSION_LABEL);
    if (false == array_key_exists($index, $_SESSION)) {
        return ["00 - session variable '{$index}' is not initialized."];
    } elseif (!empty($_SESSION[$index])) {
        return [sprintf(
            '01 - session variable "%s" not properly set (type=%s).',
            $GLOBALS['._pirogue.user_session.label_user'],
            gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_user']])
        )];
    } else {
        return [];
    }
});
