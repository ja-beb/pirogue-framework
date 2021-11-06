<?php

/**
 * Test pirogue\user_session_data_save().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_data_init;
use function pirogue\_user_session_data_dispose;
use function pirogue\user_session_data_save;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session_data.php']);

$GLOBALS['._pirogue-testing.user_session_data.label'] =  '._pirogue-testing.user_session_data.label';
$_SESSION = [];
_user_session_data_init($GLOBALS['._pirogue-testing.user_session_data.label']);

function _save_test(string $key, mixed $value): string
{
    user_session_data_save($key, $value);
    $value_session = $_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$key] ?? null;
    return $value != $value_session ? sprintf('invalid value for "%s"', $key) : '';
}

pirogue_test_execute('pirogue\user_session_data_save()', fn() => _save_test('@key', 'value'));
pirogue_test_execute('pirogue\user_session_data_save()', fn() => _save_test('@key', 1.23));
pirogue_test_execute('pirogue\user_session_data_save()', fn() => _save_test('@key', ['apples', 'oranges']));
_user_session_data_dispose();
unset($_SESSION);
