<?php

/**
 * library for working with user session - handles start, end, fetching current, and working with sessioned variables.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\user_session;

/**
 * label for user's session account data.
 * @internal
 * @var string $GLOBALS['._pirogue.user_session.label_user']
 */
$GLOBALS['._pirogue.user_session.label_user'] = '';

/**
 * label for user's session data.
 * @internal
 * @var string $GLOBALS['._pirogue.user_session.label_user']
 */
$GLOBALS['._pirogue.user_session.label_data'] = '';

/**
 * initialize user session library.
 * @uses _dispose()
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the index label to use for storing user session data in the $_SESSION array.
 * @return void
 */
function _init(string $label): void
{
    $GLOBALS['._pirogue.user_session.label_user'] = sprintf('%s_user', $label);
    $GLOBALS['._pirogue.user_session.label_data'] = sprintf('%s_data', $label);

    // initialize session variables if needed.
    if (!array_key_exists($GLOBALS['._pirogue.user_session.label_user'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
    }

    if (!array_key_exists($GLOBALS['._pirogue.user_session.label_data'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    }

    register_shutdown_function('pirogue\user_session\_dispose');
}

/**
 * writes session data before exiting.
 * @internal
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @return void
 */
function _dispose(): void
{
    session_id() && session_write_close();
    if (array_key_exists('._pirogue.user_session.label_user', $GLOBALS)) {
        unset($GLOBALS['._pirogue.user_session.label_user']);
    }
    if (array_key_exists('._pirogue.user_session.label_data', $GLOBALS)) {
        unset($GLOBALS['._pirogue.user_session.label_data']);
    }
}

/**
 * start new user session - this will clobber and existing session.
 * @internal
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @param array $user the user's account data.
 * @return void
 */
function _start(array $user): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $user;
}

/**
 * end the current user session.
 * @internal
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @param bool $clear flag used to determine if session data should be cleared.
 */
function _end(bool $clear = false): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
    if ($clear) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    }
}

/**
 * get current user's data.
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @return array current user session data or null if no session data exists.
 */
function current_session(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ?? null;
}

/**
 * save session variable.
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to save.
 * @param string $value the value to store.
 * @return void
 */
function save(string $label, mixed $value): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;
}

/**
 * fetch a saved session variable.
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to fetch.
 * @param mixed $default the default value to return if the variable is not found.
 * @return mixed stored variable or the default value given if not found.
 */
function restore(string $label, mixed $default = null): mixed
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? $default;
}

/**
 * remove a session variable and return value.
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to fetch.
 * @param mixed $default the default value to return if the variable is not found.
 * @return mixed the removed variable or the default value given if not found.
 */
function remove(string $label, mixed $default = null): mixed
{
    $value = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? $default;
    unset($_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label]);
    return $value;
}

/**
 * check if session variable exists.
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label to check if exists.
 * @return bool a flag representing if variable exists.
 */
function exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']]);
}

/**
 * clear all sessioned variables.
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @return array the session variables before cleared.
 */
function clear(): array
{
    $data = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']];
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    return $data;
}
