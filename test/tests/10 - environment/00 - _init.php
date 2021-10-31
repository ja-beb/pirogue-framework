<?php

/**
 * Test pirogue\session\environment\_init() and pirogue\session\environment\_dispose().
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

pirogue_test_execute('_init()', function () {
    if (!array_key_exists('._pirogue.session.environment.label', $GLOBALS)) {
        return 'variable ._pirogue.session.environment.label not intialized.';
    } elseif ($GLOBALS['._pirogue-testing.session.environment.label'] != $GLOBALS['._pirogue.session.environment.label']) {
        return 'variable ._pirogue.session.environment.label has wrong value.';
    } else {
        return '';
    }
});

pirogue_test_execute('_init()', function () {
    if (!array_key_exists($GLOBALS['._pirogue.session.environment.label'], $_SESSION)) {
        return 'session variable array not initialized';
    } elseif (!is_array($_SESSION[$GLOBALS['._pirogue.session.environment.label']])) {
        return 'session variable not an array';
    } else {
        return '';
    }
});

environment\_dispose();
unset($_SESSION);
