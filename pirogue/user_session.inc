<?php

/**
 * User session functions
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

$GLOBALS['._pirogue.user_session.label_user'] = '';
$GLOBALS['._pirogue.user_session.label_data'] = '';

function __user_session(string $label)
{
    $GLOBALS['._pirogue.user_session.label_user'] = "{$label}.user";
    $GLOBALS['._pirogue.user_session.label_data'] = "{$label}.data";

    session_id() || session_start();

    if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_user'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = null;
    }

    if (false == array_key_exists($GLOBALS['._pirogue.user_session.label_data'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    }
}

function user_session_current(): ?array
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] ?? null;
}

function user_session_set(string $label, $value)
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] = $value;
}

function user_session_get(string $label)
{
    return $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
}

function user_session_remove(string $label)
{
    $value = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label] ?? null;
    unset($_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$label]);
    return $value;
}

function user_session_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']]);
}

function user_session_clear(string $label): array
{
    $data = $_SESSION[$GLOBALS['._pirogue.user_session.label_data']];
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    return $data;
}

function _user_session_start(?array $user_data)
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $user_data;
}