<?php

/**
 * Test pirogue\user_session_data_clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_data_init;
use function pirogue\_user_session_data_dispose;
use function pirogue\user_session_data_clear;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session_data.php']);

$GLOBALS['._pirogue-testing.user_session_data.label'] =  '._pirogue-testing.user_session_data.label';
$_SESSION = [];
_user_session_data_init($GLOBALS['._pirogue-testing.user_session_data.label']);

pirogue_test_execute('pirogue\user_session_data_clear() - verify return value.', function () {
    $environment = [
        '@test-index' => 'test-value',
        '@test-number' => 3.14,
        '#test-array' => ['apples', 'oranges'],
        '!test-object' => new StdClass(),
    ];
    $_SESSION[$GLOBALS['._pirogue.user_session_data.label']] = $environment;

    // clear and check if return equals set values.
    return user_session_data_clear() != $environment ?  'Returned variables do not match initial state.' : '';
});

pirogue_test_execute('pirogue\user_session_data_clear(): value not cleard.', fn() => empty($_SESSION[$GLOBALS['._pirogue.user_session_data.label']]) ? '' : 'Registered variables did not cleared.');


_user_session_data_dispose();
unset($_SESSION);
