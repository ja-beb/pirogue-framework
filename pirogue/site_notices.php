<?php

/**
 * Pass notifications between pages using the client's session data.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

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
function pirogue_site_notices_init(string $index): void
{
    $GLOBALS['._pirogue.site_notices.index'] = $index;
    $_SESSION[$GLOBALS['._pirogue.site_notices.index']] ??= [];
}

/**
 * Fetch existing notices from sessioned list and clear list.
 *
 * @return array
 */
function pirogue_site_notices_clear(): array
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
function pirogue_site_notices_create(string $type, string $message): void
{
    array_push($_SESSION[$GLOBALS['._pirogue.site_notices.index']], [
        $type,
        $message
    ]);
}