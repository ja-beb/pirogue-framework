<?php

/**
 * A collection of user session functions. Used to start, end and retrieve
 * user session and user sessioned data.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 * Session array index label for user's account.
 *
 * @internal use by library only.
 * @var string $GLOBALS['._pirogue.user_session.label_user']
 */
$GLOBALS['._pirogue.user_session.label_user'] = '';

/**
 * Session array index label for user's stored data.
 *
 * @internal use by library only.
 * @var string $GLOBALS['._pirogue.user_session.label_user']
 */
$GLOBALS['._pirogue.user_session.label_data'] = '';

/**
 * initialize user session library.
 *
 * @uses _pirogue_user_session_destruct
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the index label to use for storing user session data in the $_SESSION array.
 */
function pirogue_user_session_init(string $label): void
{
    $GLOBALS['._pirogue.user_session.label_user'] = sprintf('%s_user', $label);
    $GLOBALS['._pirogue.user_session.label_data'] = sprintf('%s_data', $label);

    // initialize session variables if needed.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ??= null;
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] ??= [];

    register_shutdown_function('_pirogue_user_session_destruct');
}

/**
 * user session destructor.
 * writes session data before exiting.
 *
 * @internal used by library only.
 */
function _pirogue_user_session_destruct(): void
{
    session_id() && session_write_close();
}

/**
 * get current user's information.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @return array current user session data or null if no session data exists.
 */
function pirogue_user_session_current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ?? null;
}

/**
 * save session variable.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to save.
 * @param string $value the value to store.
 */
function pirogue_user_session_set(string $label, mixed $value): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;
}

/**
 * fetch a saved session variable.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to fetch.
 * @return string stored variable or null if not found.
 */
function pirogue_user_session_get(string $label): mixed
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
}

/**
 * remove a session variable and return value.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to fetch.
 * @return string sessioned variable's value that was removed or null if not found.
 */
function pirogue_user_session_remove(string $label): mixed
{
    $value = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
    unset($_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label]);
    return $value;
}

/**
 * check if session variable exists.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the value to check for.
 * @return bool a flag representing if variable exists.
 */
function pirogue_user_session_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']]);
}

/**
 * clear all sessioned variables.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @return array the sessioned variables before cleared.
 */
function pirogue_user_session_clear(): array
{
    $data = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']];
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    return $data;
}

/**
 * start user session.
 *
 * @internal used by dispatcher or login/logout only.
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @param array $user the user's account data.
 */
function _pirogue_user_session_start(array $user): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $user;
}

/**
 * End user session.
 *
 * @internal used by disaptcher or login/logout modules only.
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @param bool $clear flag used to determine if session data should be cleared.
 */
function _pirogue_user_session_end(bool $clear = false): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;

    if ($clear) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    }
}
