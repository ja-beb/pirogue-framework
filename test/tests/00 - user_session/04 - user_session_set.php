<?php

/**
 * Test user_session_set().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session_set;
use function pirogue\user_session_init;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

// test user_session_set()
pirogue_test_execute('user_session_set()', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        user_session_set($key, $value);
        if ($value != $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$key]) {
            return sprintf('invalid value for "%s"', $key);
        }
    }
    return '';
});
