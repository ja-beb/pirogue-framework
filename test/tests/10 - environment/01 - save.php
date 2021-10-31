<?php

/**
 * Test pirogue\session\environment\save().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\environment;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'environment.php']);

$GLOBALS['._pirogue-testing.session.environment.label'] =  '._pirogue-testing.session.environment.label';
$_SESSION = [];
environment\_init($GLOBALS['._pirogue-testing.session.environment.label']);

function _environment_save_test(string $key, mixed $value): string
{
    environment\save($key, $value);
    $value_session = $_SESSION[$GLOBALS['._pirogue.session.environment.label']][$key] ?? null;
    return $value != $value_session ? sprintf('invalid value for "%s"', $key) : '';
}

pirogue_test_execute('save()', function () {
    $msg = _environment_save_test('@key', 'value');
    if ('' != $msg) {
        return $msg;
    }

    $msg = _environment_save_test('@key', 1.23);
    if ('' != $msg) {
        return $msg;
    }

    $msg = _environment_save_test('@key', ['apples', 'oranges']);
    if ('' != $msg) {
        return $msg;
    }

    $obj = new StdClass();
    $obj->Nmae = 'Test Object';
    return _environment_save_test('@key', $obj);
});

environment\_dispose();
unset($_SESSION);
