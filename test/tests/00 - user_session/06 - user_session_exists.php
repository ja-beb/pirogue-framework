<?php

/**
 * Test user_session_exists().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session_exists;
use function pirogue\user_session_init;
use function pirogue\user_session_set;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

pirogue_test_execute('user_session_exists(): verify values not in array are not returned.', function () {
    $_SESSION = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    // test for values before set.
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        if (user_session_exists($key)) {
            return sprintf('Value "%s" exists before set.', $key);
        }
    }
    return '';
});

pirogue_test_execute('user_session_exists(): verify values are exist after being set. ', function () {
    $_SESSION = [];
    $errors = [];
    user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

    // test for values before set.
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        user_session_set($key, $value);
        if (!user_session_exists($key)) {
            return sprintf('Value "%s" does not exists after being set.', $key);
        }
    }
    return '';
});
