<?php

/**
 * library for passing user notifications between pages.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\site_notices;

/**
 * index for storing site notices in the global session array.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.site_notices.index']
 */
$GLOBALS['._pirogue.site_notices.index'] = '';

/**
 * setup site notices library.
 *
 * @internal
 * @uses $GLOBALS['._pirogue.site_notices.index']
 *
 * @param string $index the session array index for site notices.
 * @return void
 */
function _init(string $index): void
{
    $GLOBALS['._pirogue.site_notices.index'] = $index;
    if (!array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    }
}

/**
 * clean up library variables.
 *
 * @internal
 * @uses $GLOBALS['._pirogue.site_notices.index']
 *
 * @return void
 */
function _dispose(): void
{
    unset(
        $GLOBALS['._pirogue.site_notices.index']
    );
}

/**
 * cear existing notices from session list and return removed notices.
 *
 * @uses $GLOBALS['._pirogue.site_notices.index']
 *
 * @return array the list of cleared session notices in a [type,text] format.
 */
function clear(): array
{
    $list = $_SESSION[$GLOBALS['._pirogue.site_notices.index']];
    $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    return $list;
}

/**
 * append site notice to list of existing notices.
 *
 * @uses $GLOBALS['._pirogue.site_notices.index']
 *
 * @param int $type the code for the notice type to add.
 * @param string $message the notice's message.
 */
function create(string $type, string $message): void
{
    array_push($_SESSION[$GLOBALS['._pirogue.site_notices.index']], [$type, $message]);
}
