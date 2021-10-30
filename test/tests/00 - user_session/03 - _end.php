<?php

/**
 * Testing _end().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\user_session;

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
    user_session\_end($clear_data);
    return empty($_SESSION[$GLOBALS['._pirogue.user_session.label_data']]) ? $message_cleared : $message_not_cleared;
}

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);

$_SESSION = [];
user_session\_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
pirogue_test_execute('_end(): end session', function () {
    $_SESSION[$GLOBALS['._pirogue.user_session.label_user']] = $GLOBALS['._pirogue-testing.user_session.user'];
    user_session\_end();
    return null == user_session\current_session() ? '' : 'User session not properly ended.';
});

pirogue_test_execute('_end(): session data not cleared', fn () => _user_session_test_end(
    clear_data: true,
    message_not_cleared: 'User session data not cleared.',
));

pirogue_test_execute('_end(): session data cleared', fn () => _user_session_test_end(
    clear_data: false,
    message_cleared: 'User session data cleared.',
));

user_session\_dispose();
unset($_SESSION);
