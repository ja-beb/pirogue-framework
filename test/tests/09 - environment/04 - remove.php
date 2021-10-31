<?php

/**
 * Test remove().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>_dispose
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\environment;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'environment.php']);

$GLOBALS['._pirogue-testing.session.environment.label'] =  '._pirogue-testing.session.environment.label';
$_SESSION = [];
environment\_init($GLOBALS['._pirogue-testing.session.environment.label']);

function _environment_remove_test(string $key, mixed $value): string
{
    $_SESSION[$GLOBALS['._pirogue.session.environment.label']][$key] = $value;
    $value_remove = environment\remove($key);
    return $value != $value_remove ? sprintf('invalid value for "%s"', $key) : '';
}

pirogue_test_execute('remove()', function () {
    $msg = _environment_remove_test('@key', 'value');
    if ('' != $msg) {
        return $msg;
    }

    $msg = _environment_remove_test('@key', 1.23);
    if ('' != $msg) {
        return $msg;
    }

    $msg = _environment_remove_test('@key', ['apples', 'oranges']);
    if ('' != $msg) {
        return $msg;
    }

    $obj = new StdClass();
    $obj->Nmae = 'Test Object';
    return _environment_remove_test('@key', $obj);
});


environment\_dispose();
unset($_SESSION);
