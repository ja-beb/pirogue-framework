<?php

/**
 * User session functions
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

/**
 * Session array index label for user's account.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.user_session.label_user']
 */
$GLOBALS['._pirogue.user_session.label_user'] = '';

/**
 * Session array index label for user's stored data.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.user_session.label_user']
 */
$GLOBALS['._pirogue.user_session.label_data'] = '';

/**
 * Initialize user session library.
 * This function will call session_start() if no session exists.
 *
 * @param string $label
 *            Array index label for session data.
 */
function user_session_init(string $label): void
{
    $GLOBALS['._pirogue.user_session.label_user'] = "{$label}_user";
    $GLOBALS['._pirogue.user_session.label_data'] = "{$label}_data";

    session_id() || session_start();

    if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_user'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
    }

    if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_data'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    }
}

/**
 * Get current user's information.
 *
 * @return array
 */
function user_session_current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ?? null;
}

/**
 * Save session variable.
 *
 * @param string $label
 *            The label of the session variable to save.
 * @param string $value
 *            The value to store.
 */
function user_session_set(string $label, ?string $value): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;
}

/**
 * Fetch session variable.
 * Returns null if not found.
 *
 * @param string $label
 *            The label of the session variable to fetch.
 * @return string Sessioned variable or null if not found.
 */
function user_session_get(string $label): ?string
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
}

/**
 * Delete sessioned variable and return value.
 *
 * @param string $label
 *            The label of the session variable to fetch.
 * @return string Sessioned variable's value that was removed or null if not found.
 */
function user_session_remove(string $label): ?string
{
    $value = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
    unset($_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label]);
    return $value;
}

/**
 * Check if session variable exists.
 *
 * @param string $label
 *            The value to check for.
 * @return bool Flag representing if variable exists.
 */
function user_session_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']]);
}

/**
 * Clear all sessioned variables.
 *
 * @return array Sessioned variables before cleared.
 */
function user_session_clear(): array
{
    $data = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']];
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    return $data;
}

/**
 * Start user session.
 *
 * @internal Use by dispatcher or login/logout modules only.
 *          
 * @param array $user_data
 *            User's account data.
 */
function _user_session_start(array $user_data): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $user_data;
}

/**
 * End user session.
 *
 * @internal Use by dispatcher or login/logout modules only.
 */
function _user_session_end(): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
}
