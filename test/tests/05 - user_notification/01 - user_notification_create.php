<?php

/**
 * Testing for pirogue\user_notification_create().
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_notification_init;
use function pirogue\_user_notification_dispose;
use function pirogue\user_notification_create;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_notification.php']));

$_SESSION = [];
$GLOBALS['._pirogue-testing.user_notification.label'] = '._pirogue-testing.user_notification.notices';
_user_notification_init($GLOBALS['._pirogue-testing.user_notification.label']);

pirogue_test_execute('pirogue\user_notification_create()', function () {
    // load test messages.
    $_notices = [
        ['Mixed Up', 'Fascination Street'],
        ['Disintegration', 'Lullaby'],
        ['Head on the Door', 'In Between Days'],
        ['Kiss Me, Kiss Me, Kiss Me', 'Hot! Hot! Hot!'],
    ];

    foreach ($_notices as $notice) {
        user_notification_create($notice[0], $notice[1]);
    }

    // test contents of saved site notices.
    if (empty($_SESSION[$GLOBALS['._pirogue.user_notification.label']])) {
        return '00 - no site notices exist.';
    } elseif ($_notices != $_SESSION[$GLOBALS['._pirogue.user_notification.label']]) {
        return '01 - site notice list does not match.';
    } else {
        return '';
    }
});

_user_notification_dispose();
unset($_SESSION);
