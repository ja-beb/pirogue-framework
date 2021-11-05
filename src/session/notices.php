<?php

/**
 * passing user internal between pages.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\session;

/**
 * label for storing notices.
 * @internal
 * @var string $GLOBALS['._pirogue.session.notices.label']
 */
$GLOBALS['._pirogue.session.notices.label'] = '';

/**
 * setup notices library.
 * @internal
 * @uses $GLOBALS['._pirogue.session.notices.label']
 * @param string $label the session array index for notices.
 * @return void
 */
function _notices_init(string $label): void
{
    $GLOBALS['._pirogue.session.notices.label'] = $label;
    if (!array_key_exists($GLOBALS['._pirogue.session.notices.label'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.session.notices.label']] = [];
    }
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.session.notices.label']
 * @return void
 */
function _notices_dispose(): void
{
    unset(
        $GLOBALS['._pirogue.session.notices.label']
    );
}

/**
 * append site notice to list of existing notices.
 * @uses $GLOBALS['._pirogue.session.notices.label']
 * @param string $type the code for the notice type to add.
 * @param string $message the notice's message.
 */
function notices_create(string $type, string $message): void
{
    array_push($_SESSION[$GLOBALS['._pirogue.session.notices.label']], [$type, $message]);
}

/**
 * clear existing notices from session list and return removed notices.
 * @uses $GLOBALS['._pirogue.session.notices.label']
 * @return array the list of cleared session notices in a [type,text] format.
 */
function notices_clear(): array
{
    $list = $_SESSION[$GLOBALS['._pirogue.session.notices.label']];
    $_SESSION[$GLOBALS['._pirogue.session.notices.label']] = [];
    return $list;
}
