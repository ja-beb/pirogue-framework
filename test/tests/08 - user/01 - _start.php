<?php

/**
 * Testing pirogue\session\user\_start().
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

pirogue_test_execute('_start(): null session', fn() => null != $_SESSION[$GLOBALS['._pirogue.session.user.label']] ? 'User session contains values before being set.' : '');

// test _user_session_start() - check for session set.
pirogue_test_execute('_user_session_start(): session set', function () {
    user\_start($GLOBALS['._pirogue-testing.session.user']);
    return $_SESSION[$GLOBALS['._pirogue.session.user.label']] == $GLOBALS['._pirogue-testing.session.user']
        ? ''
        : 'User session not properly set.';
});

// clean up testin environment.
user\_dispose();
unset($_SESSION);
