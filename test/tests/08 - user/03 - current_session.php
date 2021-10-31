<?php

/**
 * Testing pirogue\session\user\current().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\user;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'user.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.session.user.label'] = '.testin-user-session';
$GLOBALS['._pirogue-testing.session.user'] = ['id' => 1, 'name' => 'test user'];
user\_init($GLOBALS['._pirogue-testing.session.user.label']);

pirogue_test_execute('current(): verify that session is null', fn() => null == user\current() ? '' : 'User session contains values before being set.');
pirogue_test_execute('current(): verify that session exists', function () {
    $_SESSION[$GLOBALS['._pirogue.session.user.label']] = ['id' => 1, 'name' => 'test user'];
    return match (user\current()) {
        $GLOBALS['._pirogue-testing.session.user'] => '',
        null => 'User data not set.',
        default => 'Invalid user data returned.',
    };
});

// clean up testin environment.
user\_dispose();
unset($_SESSION);
