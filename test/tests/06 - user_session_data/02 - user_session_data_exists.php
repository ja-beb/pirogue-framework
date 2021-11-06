<?php

/**
 * Test pirogue\user_session_data_exists().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_data_init;
use function pirogue\_user_session_data_dispose;
use function pirogue\user_session_data_exists;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session_data.php']);

$GLOBALS['._pirogue-testing.user_session_data.label'] =  '._pirogue-testing.user_session_data.label';
$_SESSION = [];
_user_session_data_init($GLOBALS['._pirogue-testing.user_session_data.label']);

pirogue_test_execute('pirogue\user_session_data_exists(): verify values not in array are not returned.', fn() => user_session_data_exists('@test-index') ? 'returned exists = true on empty array' : '');
pirogue_test_execute('pirogue\user_session_data_exists(): verify values are exist after being set. ', function () {
    $_SESSION[$GLOBALS['._pirogue.user_session_data.label']]['@test-index'] = 'texst-value';
    return user_session_data_exists('@test-index') ? '' : 'does not find return exists=true';
});

// clean up testing.
_user_session_data_dispose();
unset($_SESSION);
