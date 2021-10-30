<?php

/**
 * Test exists().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session\exists;
use function pirogue\user_session\_init;
use function pirogue\user_session\_end;
use function pirogue\user_session\_dispose;
use function pirogue\user_session\save;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

$_SESSION = [];
_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
pirogue_test_execute('user_session_exists(): verify values not in array are not returned.', function () {
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        if (exists($key)) {
            return sprintf('Value "%s" exists before set.', $key);
        }
    }
    return '';
});

pirogue_test_execute('user_session_exists(): verify values are exist after being set. ', function () {
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        save($key, $value);
        if (!exists($key)) {
            return sprintf('Value "%s" does not exists after being set.', $key);
        }
    }
    return '';
});

// clean up testing.
_end(true);
_dispose();
