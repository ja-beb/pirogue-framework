<?php

/**
 * Test the user session functions.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']));

pirogue_test_execute('pirogue_user_session_init:', function () {
    $test_label = 'test-label';
    pirogue_user_session_init($test_label);

    $_errors = [];
    if (false == array_key_exists('._pirogue.user_session.label_user', $GLOBALS)) {
        array_push($_errors, '00 - var "._pirogue.user_session.label_user" not initialized.');
    } elseif ("{$test_label}_user" != $GLOBALS['._pirogue.user_session.label_user']) {
        array_push($_errors, '01 - var "._pirogue.user_session.label_user" not properly set.');
    }

    if (false == array_key_exists('._pirogue.user_session.label_data', $GLOBALS)) {
        array_push($_errors, '02 - var "._pirogue.user_session.label_data" not initialized.');
    } elseif ("{$test_label}_data" != $GLOBALS['._pirogue.user_session.label_data']) {
        array_push($_errors, '03 - var "._pirogue.user_session.label_data" not properly set.');
    }

    if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_user'], $_SESSION)) {
        array_push(
            $_errors,
            "04 - session variable '{$GLOBALS['._pirogue.user_session.label_user']}' not initialized."
        );
    } elseif (null != $_SESSION[$GLOBALS['._pirogue.user_session.label_user']]) {
        array_push(
            $_errors,
            sprintf(
                "05 - session variable '{$GLOBALS['._pirogue.user_session.label_user']}' not properly set (type=%s).",
                gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_user']])
            )
        );
    }

    if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_data'], $_SESSION)) {
        array_push(
            $_errors,
            "06 - session variable '{$GLOBALS['._pirogue.user_session.label_data']}' not initialized."
        );
    } elseif (!is_array($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
        array_push(
            $_errors,
            sprintf(
                "07 - session variable '{$GLOBALS['._pirogue.user_session.label_data']}' not properly set (type=%s).",
                gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])
            )
        );
    } elseif (!empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
        array_push(
            $_errors,
            "08 - session variable '{$GLOBALS['._pirogue.user_session.label_data']}' not properly set."
        );
    }
    return $_errors;
});
