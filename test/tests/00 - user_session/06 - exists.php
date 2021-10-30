<?php

/**
 * Test exists().
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
pirogue_test_execute('user_session_exists(): verify values not in array are not returned.', function () {
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        if (user_session\exists($key)) {
            return sprintf('Value "%s" exists before set.', $key);
        }
    }
    return '';
});

pirogue_test_execute('user_session_exists(): verify values are exist after being set. ', function () {
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        user_session\save($key, $value);
        if (!user_session\exists($key)) {
            return sprintf('Value "%s" does not exists after being set.', $key);
        }
    }
    return '';
});

// clean up testing.
user_session\_end(true);
user_session\_dispose();
unset($_SESSION);
