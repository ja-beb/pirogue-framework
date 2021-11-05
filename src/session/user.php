<?php

/**
 * start, end and fetch current user session.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\session;

/**
 * label for user's account data.
 * @internal
 * @var string $GLOBALS['._pirogue.session.user.label']
 */
$GLOBALS['._pirogue.session.user.label'] = '';

/**
 * initialize user session library.
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @param string $label the index label to use for storing user session data in the $_SESSION array.
 * @return void
 */
function _user_init(string $label): void
{
    $GLOBALS['._pirogue.session.user.label'] = $label;
    if (!array_key_exists($GLOBALS['._pirogue.session.user.label'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.session.user.label']] = null;
    }
}

/**
 * dispose of this library.
 * @internal
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @return void
 */
function _user_dispose(): void
{
    if (array_key_exists('._pirogue.session.user.label', $GLOBALS)) {
        unset($GLOBALS['._pirogue.session.user.label']);
    }
}

/**
 * save session if currently active.
 * @internal
 * @return void
 */
function _user_write(): void
{
    session_id() && session_write_close();
}

/**
 * save account data as the current session.
 * @internal
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @param array $user the user's account data.
 * @return void
 */
function _user_save(array $user): void
{
    $_SESSION[$GLOBALS['._pirogue.session.user.label']] = $user;
}

/**
 * destory the current user session.
 * @internal
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @return void
 */
function _user_destroy(): void
{
    unset($_SESSION[$GLOBALS['._pirogue.session.user.label']]);
}

/**
 * get the current user's account data if present.
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @return array current user session data or null if no session data exists.
 */
function user_current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.session.user.label']] ?? null;
}
