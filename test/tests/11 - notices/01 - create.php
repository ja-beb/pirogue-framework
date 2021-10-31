<?php

/**
 * Testing for pirogue\session\notices\create().
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

pirogue_test_execute('create()', function () {
    // load test messages.
    $_notices = [
        ['Mixed Up', 'Fascination Street'],
        ['Disintegration', 'Lullaby'],
        ['Head on the Door', 'In Between Days'],
        ['Kiss Me, Kiss Me, Kiss Me', 'Hot! Hot! Hot!'],
    ];

    foreach ($_notices as $notice) {
        notices\create($notice[0], $notice[1]);
    }

    // test contents of saved site notices.
    if (empty($_SESSION[$GLOBALS['._pirogue.session.notices.label']])) {
        return '00 - no site notices exist.';
    } elseif ($_notices != $_SESSION[$GLOBALS['._pirogue.session.notices.label']]) {
        return '01 - site notice list does not match.';
    } else {
        return '';
    }
});

notices\_dispose();
unset($_SESSION);
