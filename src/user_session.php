<?php

/**
 * A collection of user session functions. Used to start, end and retrieve
 * user session and user sessioned data.
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
 * Initialize user session library.
 * This function will call session_start() if no session exists.
 *
 * @uses _pirogue_user_session_destruct
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the index label to use for storing user session data in the $_SESSION array.
 */
function pirogue_user_session_init(string $label): void
{
    $GLOBALS['._pirogue.user_session.label_user'] = "{$label}_user";
    $GLOBALS['._pirogue.user_session.label_data'] = "{$label}_data";

    // initialize session variables if needed.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ??= null;
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] ??= [];

    register_shutdown_function('_pirogue_user_session_destruct');
}

/**
 * User Session destructor. Writes session data before exiting.
 *
 * @internal used by library only.
 */
function _pirogue_user_session_destruct(): void
{
    session_id() && session_write_close();
}

/**
 * Get current user's information.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @return array current user session data or null if no session data exists.
 */
function pirogue_user_session_current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ?? null;
}

/**
 * Save session variable.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to save.
 * @param string $value the value to store.
 */
function pirogue_user_session_set(string $label, ?string $value): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;
}

/**
 * Fetch session variable.
 * Returns null if not found.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to fetch.
 * @return string sessioned variable or null if not found.
 */
function pirogue_user_session_get(string $label): ?string
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
}

/**
 * Delete sessioned variable and return value.
 *
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the label of the session variable to fetch.
 * @return string sessioned variable's value that was removed or null if not found.
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
 * @uses $GLOBALS['._pirogue.user_session.label_data']
 * @param string $label the value to check for.
 * @return bool a flag representing if variable exists.
 */
function pirogue_user_session_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']]);
}

/**
 * Clear all sessioned variables.
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
 * Start user session.
 *
 * @internal used by dispatcher or login/logout modules only.
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @param array $user_data the user's account data.
 */
function _pirogue_user_session_start(array $user_data): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $user_data;
}

/**
 * End user session.
 *
 * @internal used by disaptcher or login/logout modules only.
 * @uses $GLOBALS['._pirogue.user_session.label_user']
 * @internal Use by dispatcher or login/logout modules only.
 */
function _pirogue_user_session_end(): void
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
}
