<?php

/**
 * Test pirogue\user_session_data_restore).
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_data_init;
use function pirogue\_user_session_data_dispose;
use function pirogue\user_session_data_restore;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session_data.php']);

$GLOBALS['._pirogue-testing.user_session_data.label'] =  '._pirogue-testing.user_session_data.label';
$_SESSION = [];
_user_session_data_init($GLOBALS['._pirogue-testing.user_session_data.label']);

function _restore_test(string $key, mixed $value): string
{
    $_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$key] = $value;
    $value_restore = user_session_data_restore($key);
    return $value != $value_restore ? sprintf('invalid value for "%s"', $key) : '';
}

pirogue_test_execute('pirogue\user_session_data_restore()', fn ()  => _restore_test('@key', 'value'));
pirogue_test_execute('pirogue\user_session_data_restore()', fn ()  => _restore_test('@key', 1.23));
pirogue_test_execute('pirogue\user_session_data_restore()', fn ()  => _restore_test('@key', ['apples', 'oranges']));
pirogue_test_execute('pirogue\user_session_data_restore()', function () {
    $obj = new StdClass();
    $obj->Nmae = 'Test Object';
    return _restore_test('@key', $obj);
});

// clean up testing.
_user_session_data_dispose();
unset($_SESSION);
