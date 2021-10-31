<?php

/**
 * Testing for pirogue\session\notices\clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\notices;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'notices.php']));

$_SESSION = [];
$GLOBALS['._pirogue-testing.session.notices.label'] = '._pirogue-testing.session.notices';
notices\_init($GLOBALS['._pirogue-testing.session.notices.label']);

pirogue_test_execute('clear()', function () {
    $_notices = [
        ['Mixed Up', 'Fascination Street'],
        ['Disintegration', 'Lullaby'],
        ['Head on the Door', 'In Between Days'],
        ['Kiss Me, Kiss Me, Kiss Me', 'Hot! Hot! Hot!'],
    ];

    $_SESSION[$GLOBALS['._pirogue-testing.session.notices.label']] = $_notices;
    $list = notices\clear();
    if (!empty($_SESSION[$GLOBALS['._pirogue-testing.session.notices.label']])) {
        return '00 - site notices were not cleared.';
    } elseif ($list != $_notices) {
        return '01 - wrong site notices were returned.';
    } else {
        return '';
    }
});

notices\_dispose();
unset($_SESSION);
