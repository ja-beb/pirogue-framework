<?php

define('_PIROGUE_TESTING_USER_SESSION_LABEL', '._pirogue-testing.user_session.label');

$GLOBALS['._pirogue-testing.user_session.list'] = [
    'int_val' => 3.14,
    'function results' => sqrt(9),
    '.function' => fn(string $msg) => "I display '{$msg}'",
    '!array' => [1. . .10],
    '@object' => new PirogueTestObject('label', 'value'),
];

$GLOBALS['._pirogue-testing.user_session.user'] = [
    'id' => 1,
    '.username' => 'admin',
    '@display name' => 'Admin User',
];

function _user_session_test_init(string $label, array $data): void
{
    $_SESSION = [];
    $_SESSION["{$label}_user"] = null;
    $_SESSION["{$label}_data"] = $data;
}

/**
 * check for values from list_src in list
 */
function _user_session_compare(array $list_src, array $list, array $errors = []): array
{
    if (!empty($list_src)) {
        $key = key($list_src);
        if (!array_key_exists($key, $list)) {
            array_push($errors, "00 - variable '{$key}' not registered.");
        } elseif ($list_src[$key] != $list[$key]) {
            array_push($errors, "01 - variable '{$key}' not set.");
        }
        return _user_session_compare(array_slice($list_src, 1), $list, $errors);
    }
    return $errors;
}
