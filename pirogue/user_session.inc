<?php

/**
 * User session functions
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

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
function pirogue_user_session_init(string $label): void
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

    register_shutdown_function(__database_collection_destruct);
}

/**
 * User Session destructor. Writes session data before exiting.
 */
function __pirogue_user_session_destruct(): void
{
    session_id() && session_write_close();
}

/**
 * Get current user's information.
 *
 * @return array
 */
function pirogue_user_session_current(): ?array
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
function pirogue_user_session_set(string $label, ?string $value): void
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
function pirogue_user_session_get(string $label): ?string
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
function pirogue_user_session_remove(string $label): ?string
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
function pirogue_user_session_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']]);
}

/**
 * Clear all sessioned variables.
 *
 * @return array Sessioned variables before cleared.
 */
function pirogue_user_session_clear(): array
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
function _pirogue_user_session_start(array $user_data): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $user_data;
}

/**
 * End user session.
 *
 * @internal Use by dispatcher or login/logout modules only.
 */
function _pirogue_user_session_end(): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
}
