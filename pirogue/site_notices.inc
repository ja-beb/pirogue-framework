<?php

/**
 * Pass notifications between pages using the client's session data.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

/**
 * Site notices index in session array.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.site_notices.index']
 */
$GLOBALS['._pirogue.site_notices.index'] = '';

/**
 * Setup site notices.
 *
 * @param string $index
 *            Session array index for site notices.
 */
function site_notices_init(string $index): void
{
    $GLOBALS['._pirogue.site_notices.index'] = $index;
    if (false == array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    }
}

/**
 * Fetch existing notices from sessioned list and clear list.
 *
 * @return array
 */
function site_notices_clear(): array
{
    $list = $_SESSION[$GLOBALS['._pirogue.site_notices.index']];
    $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    return $list;
}

/**
 * Append site notice to list of existing notices.
 *
 * @param int $type
 *            The code for the notice type to add.
 * @param string $message
 *            The notice's message.
 */
function site_notices_create(string $type, string $message): void
{
    array_push($_SESSION[$GLOBALS['._pirogue.site_notices.index']], [
        $type,
        $message
    ]);
}
