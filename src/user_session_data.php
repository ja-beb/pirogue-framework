<?php

/**
 * work with sessioned data passed between requests.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * label used to store the user's session data in the global session array.
 * @internal
 * @var string $GLOBALS['._pirogue.user_session_data.label']
 */
$GLOBALS['._pirogue.user_session_data.label'] = '';

/**
 * initialize user session library.
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @param string $label the index label to use for storing user session data in the $_SESSION array.
 * @return void
 */
function _user_session_data_init(string $label): void
{
    $GLOBALS['._pirogue.user_session_data.label'] = $label;
    if (!array_key_exists($GLOBALS['._pirogue.user_session_data.label'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session_data.label']] = [];
    }
}

/**
 * writes session data before exiting.
 * @internal
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @return void
 */
function _user_session_data_dispose(): void
{
    if (array_key_exists('._pirogue.user_session_data.label', $GLOBALS)) {
        unset($GLOBALS['._pirogue.user_session_data.label']);
    }
}

/**
 * save session variable.
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @param string $label the label of the session variable to save.
 * @param string $value the value to store.
 * @return void
 */
function user_session_data_save(string $label, mixed $value): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$label] = $value;
}

/**
 * check if session variable exists.
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @param string $label the label to check if exists.
 * @return bool a flag representing if variable exists.
 */
function user_session_data_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session_data.label']]);
}

/**
 * fetch a saved session variable.
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @param string $label the label of the session variable to fetch.
 * @param mixed $default the default value to return if the variable is not found.
 * @return mixed the saved variable or the default value given if not found.
 */
function user_session_data_restore(string $label, mixed $default = null): mixed
{
    return $_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$label] ?? $default;
}

/**
 * remove a session variable and return value.
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @param string $label the label of the session variable to fetch.
 * @param mixed $default the default value to return if the variable is not found.
 * @return mixed the removed variable or the default value given if not found.
 */
function user_session_data_remove(string $label, mixed $default = null): mixed
{
    $value = $_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$label] ?? $default;
    unset($_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$label]);
    return $value;
}

/**
 * clear all sessioned variables.
 * @uses $GLOBALS['._pirogue.user_session_data.label']
 * @return array the session variables before cleared.
 */
function user_session_data_clear(): array
{
    $data = $_SESSION[$GLOBALS['._pirogue.user_session_data.label']];
    $_SESSION[$GLOBALS['._pirogue.user_session_data.label']] = [];
    return $data;
}
