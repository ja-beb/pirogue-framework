<?php

/**
 * Test pirogue\_user_session_data_init() and pirogue\_user_session_data_dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_session_data_init;
use function pirogue\_user_session_data_dispose;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session_data.php']);

$GLOBALS['._pirogue-testing.user_session_data.label'] =  '._pirogue-testing.user_session_data.label';
$_SESSION = [];
_user_session_data_init($GLOBALS['._pirogue-testing.user_session_data.label']);

pirogue_test_execute('pirogue\_user_session_data_init()', function () {
    if (!array_key_exists('._pirogue.user_session_data.label', $GLOBALS)) {
        return 'variable ._pirogue.user_session_data.label not intialized.';
    } elseif ($GLOBALS['._pirogue-testing.user_session_data.label'] != $GLOBALS['._pirogue.user_session_data.label']) {
        return 'variable ._pirogue.user_session_data.label has wrong value.';
    } else {
        return '';
    }
});

pirogue_test_execute('pirogue\_user_session_data_init()', function () {
    if (!array_key_exists($GLOBALS['._pirogue.user_session_data.label'], $_SESSION)) {
        return 'session variable array not initialized';
    } elseif (!is_array($_SESSION[$GLOBALS['._pirogue.user_session_data.label']])) {
        return 'session variable not an array';
    } else {
        return '';
    }
});

_user_session_data_dispose();
pirogue_test_execute('pirogue\_user_session_data_dispose()', fn () => array_key_exists('._pirogue.user_session_data.label', $GLOBALS) ? 'variable ._pirogue.user_session_data.label not removed.' : '');
pirogue_test_execute('pirogue\_user_session_data_dispose()', fn () => empty($_SESSION) ? 'session variable array removed' : '');

unset($_SESSION);
