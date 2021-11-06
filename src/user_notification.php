<?php

/**
 * pass notifications to the user between requests.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * label for storing user notifications.
 * @internal
 * @var string $GLOBALS['._pirogue.user_notification.label']
 */
$GLOBALS['._pirogue.user_notification.label'] = '';

/**
 * setup library.
 * @internal
 * @uses $GLOBALS['._pirogue.user_notification.label']
 * @param string $label the session array index for user notifications.
 * @return void
 */
function _user_notification_init(string $label): void
{
    $GLOBALS['._pirogue.user_notification.label'] = $label;
    if (!array_key_exists($GLOBALS['._pirogue.user_notification.label'], $_SESSION)) {
        $_SESSION[$GLOBALS['._pirogue.user_notification.label']] = [];
    }
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.user_notification.label']
 * @return void
 */
function _user_notification_dispose(): void
{
    unset(
        $GLOBALS['._pirogue.user_notification.label']
    );
}

/**
 * append site notice to list of existing user notifications.
 * @uses $GLOBALS['._pirogue.user_notification.label']
 * @param string $type the code for the notice type to add.
 * @param string $message the notice's message.
 */
function user_notification_create(string $type, string $message): void
{
    array_push($_SESSION[$GLOBALS['._pirogue.user_notification.label']], [$type, $message]);
}

/**
 * clear existing user notifications from session list and return removed user notifications.
 * @uses $GLOBALS['._pirogue.user_notification.label']
 * @return array the list of cleared session user notifications in a [type,text] format.
 */
function user_notification_clear(): array
{
    $list = $_SESSION[$GLOBALS['._pirogue.user_notification.label']];
    $_SESSION[$GLOBALS['._pirogue.user_notification.label']] = [];
    return $list;
}
