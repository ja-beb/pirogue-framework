<?php

/**
 * Test restore().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\user_session;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

$_SESSION = [];
user_session\_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
pirogue_test_execute('restore()', function () {

    // check for registered variables.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        if (user_session\restore($key) != $value) {
            return sprintf('invalid value for "%s"', $key);
        }
    }

    // check that default returns correct value.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        $check_key = sprintf('@@%s', $key);
        if (user_session\restore($check_key, $value) != $value) {
            return sprintf('invalid default value for "%s"', $check_key);
        }
    }
    return '';
});

user_session\_end(true);
user_session\_dispose();
unset($_SESSION);
