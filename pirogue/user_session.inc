<?php

/**
 * User session functions
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

$GLOBALS['._pirogue.user_session.label'] = '';

function __user_session(string $label)
{
    $GLOBALS['._pirogue.user_session.label'] = $label;

    session_id() || session_start();
    if (false == array_key_exists("{$GLOBALS['._pirogue.user_session.label']}.principal", $_SESSION)) {
        $_SESSION["{$GLOBALS['._pirogue.user_session.label']}.principal"] = [];
    }

    if (false == array_key_exists("{$GLOBALS['._pirogue.user_session.label']}.data", $_SESSION)) {
        $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"] = [];
    }
}

function user_session_current(): array
{
    return $_SESSION["{$GLOBALS['._pirogue.user_session.label']}.principal"] ?? [];
}

function user_session_set(string $label, $value)
{
    $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"][$label] = $value;
}

function user_session_get(string $label)
{
    return $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"][$label] ?? null;
}

function user_session_remove(string $label)
{
    $value = $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"][$label] ?? null;
    unset($_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"][$label]);
    return $value;
}

function user_session_exists(string $label): bool
{
    return array_key_exists($label, $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"]);
}

function user_session_clear(string $label): array
{
    $data = $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"];
    $_SESSION["{$GLOBALS['._pirogue.user_session.data']}.data"] = [];
    return $data;
}