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

// define global variables.
$GLOBALS['._pirogue-testing.user_session.user'] = [
    'id' => 1,
    '.username' => 'admin',
    '@display name' => 'Admin User',
];

// test pirogue_user_session_current()
pirogue_test_execute('pirogue_user_session_current', function () {
    _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
    $errors = [];

        // check for user session before it is set.
    if (null != pirogue_user_session_current()) {
        array_push($errors, '00 - user session contains values before being set.');
    }

    // manually set user session.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $GLOBALS['._pirogue-testing.user_session.user'];

        // check for user session afte set.
    if ($GLOBALS['._pirogue-testing.user_session.user'] != pirogue_user_session_current()) {
        array_push($errors, '01 - user session data did not return proper value.');
    }

    return $errors;
});

// test pirogue_user_session_current()
pirogue_test_execute('pirogue_user_session_current', function () {
    _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
    $errors = [];

    // check for user session before it is set.
    if (null != pirogue_user_session_current()) {
        array_push($errors, '00 - user session contains values before being set.');
    }

    // manually set user session.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $GLOBALS['._pirogue-testing.user_session.user'];

    // check for user session afte set.
    if ($GLOBALS['._pirogue-testing.user_session.user'] != pirogue_user_session_current()) {
        array_push($errors, '01 - user session data did not return proper value.');
    }

    return $errors;
});
