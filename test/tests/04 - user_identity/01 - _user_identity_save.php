<?php

/**
 * Testing pirogue\_user_identity_register().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_identity_init;
use function pirogue\_user_identity_dispose;
use function pirogue\_user_identity_register;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_identity.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.user_identity.user'] = ['id' => 1, 'name' => 'test user'];
$GLOBALS['._pirogue-testing.user_identity.label'] = '._pirogue-testing.user_identity';
_user_identity_init($GLOBALS['._pirogue-testing.user_identity.label']);

pirogue_test_execute('pirogue\_user_identity_register(): null session', fn() => null != $_SESSION[$GLOBALS['._pirogue.user_identity.label']] ? 'User session contains values before being set.' : '');

pirogue_test_execute('pirogue\_user_identity_register(): session set', function () {
    _user_identity_register($GLOBALS['._pirogue-testing.user_identity.user']);
    return $_SESSION[$GLOBALS['._pirogue.user_identity.label']] == $GLOBALS['._pirogue-testing.user_identity.user']
        ? ''
        : 'User session not properly set.';
});

// clean up testing environment.
_user_identity_dispose();
unset($_SESSION);
