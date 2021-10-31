<?php

/**
 * start, end and fetch current user session.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\session\user;

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
function _init(string $label): void
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
function _dispose(): void
{
    session_id() && session_write_close();
    if (array_key_exists('._pirogue.session.user.label', $GLOBALS)) {
        unset($GLOBALS['._pirogue.session.user.label']);
    }
}

/**
 * start new user session - this will clobber an existing session.
 * @internal
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @param array $user the user's account data.
 * @return void
 */
function _start(array $user): void
{
    $_SESSION[$GLOBALS['._pirogue.session.user.label']] = $user;
}

/**
 * end the current user session.
 * @internal
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @return void
 */
function _end(): void
{
    unset($_SESSION[$GLOBALS['._pirogue.session.user.label']]);
}

/**
 * get current user's data.
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @return array current user session data or null if no session data exists.
 */
function current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.session.user.label']] ?? null;
}
