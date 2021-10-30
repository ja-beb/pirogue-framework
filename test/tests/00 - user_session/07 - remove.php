<?php

/**
 * Test remove().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>_dispose
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\user_session;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

// create testing environment.
$_SESSION = [];
user_session\_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

pirogue_test_execute('remove(): ', function () {
    // check for removal of variables.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        $remove_value = user_session\remove($key);

        // verify that variable was removed.
        if (array_key_exists($key, $_SESSION[$GLOBALS['._pirogue.user_session.label_data']])) {
            return sprintf('variable "%s" not removed.', $key);
        }

        // validate treturn value.
        if ($remove_value != $value) {
            return sprintf('invalid default value for "%s"', $check_key);
        }
    }

    // check default return value.
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = [];
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        $check_key = sprintf('@@%s', $key);
        if (user_session\remove($check_key, $value) != $value) {
            return sprintf('invalid default value for "%s"', $check_key);
        }
    }

    // all test pass.
    return '';
});

// clean up enviroment
user_session\_end(true);
user_session\_dispose();
unset($_SESSION);
