<?php

/**
 * Testin tfor pirogue_user_session_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'user_session.php']);

// test pirogue_user_session_init(): ._pirogue.user_session.label_user exists
pirogue_test_execute('pirogue_user_session_init(): initialize ._pirogue.user_session.label_user', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    if (false == array_key_exists('._pirogue.user_session.label_user', $GLOBALS)) {
        return ['00 - var "._pirogue.user_session.label_user" not initialized.'];
    } elseif (sprintf('%s_user', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_user']) {
        return '01 - var "._pirogue.user_session.label_user" not properly set.';
    } else {
        return '';
    }
});

// test pirogue_user_session_init() - ._pirogue.user_session.label_data exists.
pirogue_test_execute('pirogue_user_session_init(): initialize ._pirogue.user_session.label_data', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    if (false == array_key_exists('._pirogue.user_session.label_data', $GLOBALS)) {
        return ['00 - var "._pirogue.user_session.label_data" not initialized.'];
    } elseif (sprintf('%s_data', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_data']) {
        return '01 - var "._pirogue.user_session.label_data" not properly set.';
    } else {
        return '';
    }
});

// test pirogue_user_session_init() - user data is initialized to a null value.
pirogue_test_execute('pirogue_user_session_init(): user data', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $index = sprintf('%s_user', _PIROGUE_TESTING_USER_SESSION_LABEL);

    if (false == array_key_exists($index, $_SESSION)) {
        return [sprintf('00 - session variable "%s" not initialized.', $index)];
    } elseif (null != $_SESSION[$index]) {
        return sprintf(
            '01 - session variable "%s" not properly set (type=%s).',
            $GLOBALS['._pirogue.user_session.label_user'],
            gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_user']])
        );
    } else {
        return '';
    }
});

// test pirogue_user_session_init() - verify that saved data is initialized to an empty array.
pirogue_test_execute('pirogue_user_session_init(): user data', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    $index = sprintf('%s_data', _PIROGUE_TESTING_USER_SESSION_LABEL);

    if (false == array_key_exists($index, $_SESSION)) {
        return [sprintf('00 - session variable "%s" is not initialized.', $index)];
    } elseif (!empty($_SESSION[$index])) {
        return sprintf(
            '01 - session variable "%s" not properly set (type=%s).',
            $GLOBALS['._pirogue.user_session.label_user'],
            gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_user']])
        );
    } else {
        return '';
    }
});
