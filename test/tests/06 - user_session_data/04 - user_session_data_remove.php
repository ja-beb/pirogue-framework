<?php

/**
 * Test pirogue\user_session_data_remove().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>_dispose
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_data_init;
use function pirogue\_user_session_data_dispose;
use function pirogue\user_session_data_remove;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session_data.php']);

$GLOBALS['._pirogue-testing.user_session_data.label'] =  '._pirogue-testing.user_session_data.label';
$_SESSION = [];
_user_session_data_init($GLOBALS['._pirogue-testing.user_session_data.label']);

function _environment_remove_test(string $key, mixed $value): string
{
    $_SESSION[$GLOBALS['._pirogue.user_session_data.label']][$key] = $value;
    $value_remove = user_session_data_remove($key);
    return $value != $value_remove ? sprintf('invalid value for "%s"', $key) : '';
}

pirogue_test_execute('pirogue\user_session_data_remove()', fn() => _environment_remove_test('@key', 'value'));
pirogue_test_execute('pirogue\user_session_data_remove()', fn() => _environment_remove_test('@key', 1.23));
pirogue_test_execute('pirogue\user_session_data_remove()', fn() => _environment_remove_test('@key', ['apples', 'oranges']));
pirogue_test_execute('pirogue\user_session_data_remove()', function () {
    $obj = new StdClass();
    $obj->Nmae = 'Test Object';
    return _environment_remove_test('@key', $obj);
});

_user_session_data_dispose();
unset($_SESSION);
