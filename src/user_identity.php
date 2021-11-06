<?php

/**
 * assist in the creation, retrieval and disposal of the user's identity.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * label for user's account data.
 * @internal
 * @var string $GLOBALS['._pirogue.user_identity.label']
 */
$GLOBALS['._pirogue.user_identity.label'] = '';

/**
 * initialize user session library.
 * @uses $GLOBALS['._pirogue.user_identity.label']
 * @param string $label the index label to use for storing user session data in the $_SESSION array.
 * @return void
 */
function _user_identity_init(string $label): void
{
    $GLOBALS['._pirogue.session.user.label'] = $label;
    if (!array_key_exists($GLOBALS['._pirogue.user_identity.label'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_identity.label']] = null;
    }
}

/**
 * dispose of this library.
 * @internal
 * @uses $GLOBALS['._pirogue.user_identity.label']
 * @return void
 */
function _user_identity_dispose(): void
{
    if (array_key_exists('._pirogue.user_identity.label', $GLOBALS)) {
        unset($GLOBALS['._pirogue.user_identity.label']);
    }
}

/**
 * save account data as the current session.
 * @internal
 * @uses $GLOBALS['._pirogue.user_identity.label']
 * @param array $user the user's account data.
 * @return void
 */
function _user_identity_register(array $user): void
{
    $_SESSION[$GLOBALS['._pirogue.user_identity.label']] = $user;
}

/**
 * destory the current user session.
 * @internal
 * @uses $GLOBALS['._pirogue.user_identity.label']
 * @return void
 */
function _user_identity_destroy(): void
{
    unset($_SESSION[$GLOBALS['._pirogue.user_identity.label']]);
}

/**
 * get the current user's account data if present.
 * @uses $GLOBALS['._pirogue.user_identity.label']
 * @return array current user session data or null if no session data exists.
 */
function user_identity_current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.user_identity.label']] ?? null;
}
