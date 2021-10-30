<?php

/**
 * Test clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session\clear;
use function pirogue\user_session\_init;
use function pirogue\user_session\_end;
use function pirogue\user_session\_finalize;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

// set up testing environment.
$_SESSION = [];
_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

pirogue_test_execute('clear() - verify return value.', function () {
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    // clear and check if return equals set values.
    return $GLOBALS['._pirogue-testing.user_session.list'] != clear()
        ?  'Returned variables do not match initial state.'
        : '';
});

// set up testing environment.
$_SESSION = [];
_init(_PIROGUE_TESTING_USER_SESSION_LABEL);

pirogue_test_execute('clear(): value not cleard.', function () {
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];

    return empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']])
        ? 'Registered variables did not cleared.'
        : '';
});

// clean up enviroment
_end(true);
_finalize();
