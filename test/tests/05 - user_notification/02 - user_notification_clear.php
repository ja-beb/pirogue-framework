<?php

/**
 * Testing for pirogue\session\notices\clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_notification_init;
use function pirogue\_user_notification_dispose;
use function pirogue\user_notification_clear;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_notification.php']));

$_SESSION = [];
$GLOBALS['._pirogue-testing.user_notification.label'] = '._pirogue-testing.user_notification.notices';
_user_notification_init($GLOBALS['._pirogue-testing.user_notification.label']);


pirogue_test_execute('pirogue\user_notification_clear()', function () {
    // load test messages.
    $_notices = [
        ['Mixed Up', 'Fascination Street'],
        ['Disintegration', 'Lullaby'],
        ['Head on the Door', 'In Between Days'],
        ['Kiss Me, Kiss Me, Kiss Me', 'Hot! Hot! Hot!'],
    ];

    $_SESSION[$GLOBALS['._pirogue-testing.user_notification.label']] = $_notices;
    $list = user_notification_clear();
    if (!empty($_SESSION[$GLOBALS['._pirogue-testing.user_notification.label']])) {
        return '00 - site notices were not cleared.';
    } elseif ($list != $_notices) {
        return '01 - wrong site notices were returned.';
    } else {
        return '';
    }
});

_user_notification_dispose();
unset($_SESSION);
