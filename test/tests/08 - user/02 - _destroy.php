<?php

/**
 * Testing pirogue\session\user\_destroy().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\user;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'user.php']);

$_SESSION = [];
$GLOBALS['._pirogue-testing.session.user.label'] = '.testin-user-session';
$GLOBALS['._pirogue-testing.session.user'] = ['id' => 1, 'name' => 'test user'];
user\_init($GLOBALS['._pirogue-testing.session.user.label']);

pirogue_test_execute('_end()', function () {
    $_SESSION[$GLOBALS['._pirogue.session.user.label']] = $GLOBALS['._pirogue-testing.session.user'];
    user\_destroy();
    return array_key_exists($GLOBALS['._pirogue.session.user.label'], $_SESSION) ? 'session not cleared.' : '';
});

user\_dispose();
unset($_SESSION);
