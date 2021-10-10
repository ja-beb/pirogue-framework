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

    // Test pirogue_user_session_set()
    pirogue_test_execute('pirogue_user_session_set', function () {
        $_SESSION = [];
        pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
        array_walk($GLOBALS['._pirogue-testing.user_session.list'], fn(mixed $value, string $key) => pirogue_user_session_set($key, $value));
        return _user_session_compare($GLOBALS['._pirogue-testing.user_session.list'], $_SESSION[$GLOBALS['._pirogue.user_session.label_data']], []);
    });

    // function pirogue_user_session_get(string $label): ?string
    pirogue_test_execute('pirogue_user_session_get', function () {
        $_SESSION = [];
        pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];
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

    // function pirogue_user_session_exists(string $label): bool
    pirogue_test_execute('pirogue_user_session_exists', function () {
        $_SESSION = [];
        pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
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
        $_SESSION = [];
        pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];
        $errors = [];
        if ($GLOBALS['._pirogue-testing.user_session.list'] != pirogue_user_session_clear()) {
            array_push($errors, '00 - returned variables do not match initial state.');
        }

        if (!empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            array_push($errors, '01 - registered variables did not cleared.');
        }
        return $errors;
    });
