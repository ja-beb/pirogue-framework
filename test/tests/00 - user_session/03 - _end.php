<?php

/**
 * Testing _end().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\user_session\_init;
use function pirogue\user_session\_end;
use function pirogue\user_session\_dispose;
use function pirogue\user_session\current_session;

/**
 * Helper function to test session end.
 *
 * @internal use by this test file only.
 * @param bool $clear_data clear data flag to pass to session end.
 * @param array $message_cleared array containing the message to display if data array is empty after session ended.
 * @param array $message_not_cleared array containing the message to display if data array has data after session ended.
 * @return array message for errors encountered or empty array
 */
function _user_session_test_end(bool $clear_data, string $message_cleared = '', string $message_not_cleared = ''): string
{
    $_SESSION[$GLOBALS['._pirogue.user_session.label_data']] = $GLOBALS['._pirogue-testing.user_session.list'];
    _end($clear_data);
    return empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']]) ? $message_cleared : $message_not_cleared;
}

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

$_SESSION = [];
_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
pirogue_test_execute('_user_session_end(): end session', function () {
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $GLOBALS['._pirogue-testing.user_session.user'];
    _end();
    return null == current_session() ? '' : 'User session not properly ended.';
});
_dispose();

_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
pirogue_test_execute('_user_session_end(): session data not cleared', fn () => _user_session_test_end(
    clear_data: true,
    message_not_cleared: 'User session data not cleared.',
));
_dispose();

_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
pirogue_test_execute('_user_session_end(): session data cleared', fn () => _user_session_test_end(
    clear_data: false,
    message_cleared: 'User session data cleared.',
));
_dispose();
