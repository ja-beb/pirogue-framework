<?php

/**
 * Testing for pirogue\_user_notification_init() && pirogue\_user_notification_dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_notification_init;
use function pirogue\_user_notification_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_notification.php']));

$_SESSION = [];
$GLOBALS['._pirogue-testing.user_notification.label'] = '._pirogue-testing.session.notices';
_user_notification_init($GLOBALS['._pirogue-testing.user_notification.label']);

pirogue_test_execute('_init()', function () {
    if (!array_key_exists('._pirogue.user_notification.label', $GLOBALS)) {
        return 'variable ._pirogue.user_notification.label not initialized';
    } elseif ($GLOBALS['._pirogue-testing.user_notification.label'] != $GLOBALS['._pirogue.user_notification.label']) {
        return 'Variable ._pirogue.user_notification.label contains incorrect value.';
    } else {
        return '';
    }
});

_user_notification_dispose();
pirogue_test_execute('pirogue\_user_notification_dispose()', fn() => array_key_exists('._pirogue.user_notification.label', $GLOBALS) ? 'value not cleared.' : '');
unset($_SESSION);
