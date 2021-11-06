<?php

/**
 * Testing pirogue\user_identity_current().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_identity_init;
use function pirogue\_user_identity_dispose;
use function pirogue\user_identity_current;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_identity.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.user_identity.user'] = ['id' => 1, 'name' => 'test user'];
$GLOBALS['._pirogue-testing.user_identity.label'] = '._pirogue-testing.user_identity';
_user_identity_init($GLOBALS['._pirogue-testing.user_identity.label']);

pirogue_test_execute('pirogue\user_identity_current()', function () {
    $_SESSION[$GLOBALS['._pirogue.user_identity.label']] = $GLOBALS['._pirogue-testing.user_identity.user'];
    return user_identity_current() == $GLOBALS['._pirogue-testing.user_identity.user'] ? '' : 'invalid session returned.';
});

_user_identity_dispose();
unset($_SESSION);
