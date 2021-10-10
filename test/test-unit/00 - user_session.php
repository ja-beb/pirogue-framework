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


    // initialize and reset session variable.
<<<<<<< HEAD
=======
    $_SESSION = [];
    $GLOBALS['._pirogue-testing.user_session.user'] = [
        'id' => 1,
        '.username' => 'admin',
        '@display name' => 'Admin User',
    ];
    $GLOBALS['._pirogue-testing.user_session.list'] = [
        'int_val' => 3.14,
        'function results' => sqrt(9),
        '.function' => fn(string $msg) => "I display '{$msg}'",
        '!array' => [1. . .10],
        '@object' => new PirogueTestObject('label', 'value'),
    ];
>>>>>>> test/user_session

    // test pirogue_user_session_init()
    pirogue_test_execute('pirogue_user_session_init:', function () {
        _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
        pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
        $errors = [];

        // test init - user.
        if (false == array_key_exists('._pirogue.user_session.label_user', $GLOBALS)) {
            array_push($errors, '00 - var "._pirogue.user_session.label_user" not initialized.');
        } elseif (sprintf('%s_user', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_user']) {
            array_push($errors, '01 - var "._pirogue.user_session.label_user" not properly set.');
        }

        // test init - data.
        if (false == array_key_exists('._pirogue.user_session.label_data', $GLOBALS)) {
            array_push($errors, '02 - var "._pirogue.user_session.label_data" not initialized.');
        } elseif (sprintf('%s_data', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_data']) {
            array_push($errors, '03 - var "._pirogue.user_session.label_data" not properly set.');
        }

        // test init - user data.
        if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_user'], $_SESSION)) {
            array_push(
                $errors,
                "04 - session variable '{$GLOBALS['._pirogue.user_session.label_user']}' not initialized."
            );
        } elseif (null != $_SESSION[$GLOBALS['._pirogue.user_session.label_user']]) {
            array_push(
                $errors,
                sprintf(
                    "05 - session variable '{$GLOBALS['._pirogue.user_session.label_user']}' not properly set (type=%s).",
                    gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_user']])
                )
            );
        }

        // test init - data list.
        if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_data'], $_SESSION)) {
            array_push(
                $errors,
                "06 - session variable '{$GLOBALS['._pirogue.user_session.label_data']}' not initialized."
            );
        } elseif (!is_array($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            array_push(
                $errors,
                sprintf(
                    "07 - session variable '{$GLOBALS['._pirogue.user_session.label_data']}' not properly set (type=%s).",
                    gettype($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])
                )
            );
        } elseif (!empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            array_push(
                $errors,
                "08 - session variable '{$GLOBALS['._pirogue.user_session.label_data']}' not properly set."
            );
        }

        return $errors;
    });

    // Test pirogue_user_session_set()
    pirogue_test_execute('pirogue_user_session_set', function () {
        _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
        array_walk($GLOBALS['._pirogue-testing.user_session.list'], fn(mixed $value, string $key) => pirogue_user_session_set($key, $value));
        return _user_session_compare($GLOBALS['._pirogue-testing.user_session.list'], $_SESSION[$GLOBALS['._pirogue.user_session.label_data']], []);
    });

    // function pirogue_user_session_get(string $label): ?string
    pirogue_test_execute('pirogue_user_session_get', function () {
        _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, $GLOBALS['._pirogue-testing.user_session.list']);
        $errors = [];
        foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
            if ($value != pirogue_user_session_get($key)) {
                array_push($errors, "00 - variable {$key} not set.");
            }
        }
        return $errors;
    });

    // function pirogue_user_session_remove(string $label): ?string
    pirogue_test_execute('pirogue_user_session_remove', function () {
        _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, $GLOBALS['._pirogue-testing.user_session.list']);
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

    // function pirogue_user_session_exists(string $label): bool
    pirogue_test_execute('pirogue_user_session_exists', function () {
        _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, []);
        $errors = [];
        $key_list = array_keys($GLOBALS['._pirogue-testing.user_session.list']);

        // test for values before set.
        foreach ($key_list as $key) {
            if (pirogue_user_session_exists($key)) {
                array_push($errors, "00 - value '{$key}' exists before set.");
            }
        }

        // test for values after set.
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];
        foreach ($key_list as $key) {
            if (!pirogue_user_session_exists($key)) {
                array_push($errors, "01 - value '{$key}' does not exists after being set.");
            }
        }
        return $errors;
    });

    // pirogue_user_session_clear(): array
    pirogue_test_execute('pirogue_user_session_clear', function () {
        _user_session_test_init(_PIROGUE_TESTING_USER_SESSION_LABEL, $GLOBALS['._pirogue-testing.user_session.list']);
        $errors = [];
        if ($GLOBALS['._pirogue-testing.user_session.list'] != pirogue_user_session_clear()) {
            array_push($errors, '00 - returned variables do not match initial state.');
        }

        if (!empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            array_push($errors, '01 - registered variables did not cleared.');
        }
        return $errors;
    });
