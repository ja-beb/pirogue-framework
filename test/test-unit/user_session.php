<?php

/**
 * Test the user session functions.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

 // load required library.
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'user_session.php']));

// define testing constants.
define('_PIROGUE_TESTING_USER_SESSION_LABEL', '._pirogue-testing.user_session.label');

// define test object.
class PirogueTestObject
{
    public function __construct(
        public string $label,
        public string $value
    ) {
    }

    public function __toString(): string {
        return '';
    }
}

function _user_session_reset(): void
{
    $_SESSION[_PIROGUE_TESTING_USER_SESSION_LABEL] = null;
    $_SESSION[_PIROGUE_TESTING_USER_SESSION_LABEL] = [];
}

// initialize and reset session variable.
$_SESSION = [];
$GLOBALS['._pirogue-testing.user_session.list'] = [
    'int_val' => 3.14,
    'function results' => sqrt(9),
    '.function' => fn(string $msg) => "I display '{$msg}'",
    '!array' => [1. . .10],
    '@object' => new PirogueTestObject('label', 'value'),
];

// test pirogue_user_session_init()
pirogue_test_execute('pirogue_user_session_init:', function () {
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    $errors = [];
    if (false == array_key_exists('._pirogue.user_session.label_user', $GLOBALS)) {
        array_push($errors, '00 - var "._pirogue.user_session.label_user" not initialized.');
    } elseif (sprintf('%s_user', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_user']) {
        array_push($errors, '01 - var "._pirogue.user_session.label_user" not properly set.');
    }

    if (false == array_key_exists('._pirogue.user_session.label_data', $GLOBALS)) {
        array_push($errors, '02 - var "._pirogue.user_session.label_data" not initialized.');
    } elseif (sprintf('%s_data', _PIROGUE_TESTING_USER_SESSION_LABEL) != $GLOBALS['._pirogue.user_session.label_data']) {
        array_push($errors, '03 - var "._pirogue.user_session.label_data" not properly set.');
    }

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

// test pirogue_user_session_current(), _pirogue_user_session_start() and _pirogue_user_session_end()
pirogue_test_execute('pirogue_user_session_current', function () {
    _user_session_reset();
    $errors = [];
    $user = ['id' => 1];

    if (null != pirogue_user_session_current()) {
        array_push($errors, '00 - user session contains values before being set.');
    }

    _pirogue_user_session_start($user);
    if ($user != pirogue_user_session_current()) {
        array_push($errors, '01 - user session data not properly set.');
    }

    _pirogue_user_session_end();
    if (null != pirogue_user_session_current()) {
        array_push($errors, '02 - user session data not properly destoryed.');
    }

    return $errors;
});

// Test pirogue_user_session_set()
pirogue_test_execute('pirogue_user_session_set', function () {
    _user_session_reset();
    $label = '!my label';
    $value = "@my value";
    $errors = [];

    pirogue_user_session_set($label, $value);
    if (!array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
        array_push($errors, "00 - '{$label}' not set.");
    } elseif ($value != $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label]) {
        array_push($errors, "01 - '{$label}' contains the wrong value.");
    }
    return $errors;
});

// function pirogue_user_session_get(string $label): ?string
pirogue_test_execute('pirogue_user_session_get', function () {
    _user_session_reset();
    $label = '!pirogue_user_session_get.key';
    $value = "@my value";

    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;

    return ($value != pirogue_user_session_get($label))
        ? ['Invalid value retrieved.']
        : [];
});

// function pirogue_user_session_remove(string $label): ?string
pirogue_test_execute('pirogue_user_session_remove', function () {
    _user_session_reset();
    $label = '!pirogue_user_session_remove.key';
    $value = "@my value";
    $errors = [];

    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;
    $del_value = pirogue_user_session_remove($label);
    if ($value != $del_value) {
        array_push($errors, '00 - returned value does not match set value.');
    }

    if (array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
        array_push($errors, '00 - value not unset.');
    }

    return $errors;
});

// function pirogue_user_session_exists(string $label): bool
pirogue_test_execute('pirogue_user_session_exists', function () {
    _user_session_reset();
    $label = '!pirogue_user_session_exists.key';
    $value = "@my value";
    $errors = [];

    if (pirogue_user_session_exists($label)) {
        array_push($errors, '00 - value exists before set.');
    }

    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;

    if (!pirogue_user_session_exists($label)) {
        array_push($errors, '01 - value does not exists after set.');
    }

    return $errors;
});

// pirogue_user_session_clear(): array
pirogue_test_execute('pirogue_user_session_clear', function () {
    _user_session_reset();
    $saved_state = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']];
    $errors = [];
    if ($saved_state != pirogue_user_session_clear()) {
        array_push($errors, '00 - returned variables do not match initial state.');
    }

    if (!empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
        array_push($errors, '01 - registered variables did not cleared.');
    }

    return $errors;
});
