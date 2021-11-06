<?php

/**
 * Testing for pirogue\session\notices\_init() && _dispose.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\session\notices;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'session', 'notices.php']));

$_SESSION = [];
$GLOBALS['._pirogue-testing.session.notices.label'] = '._pirogue-testing.session.notices';
notices\_init($GLOBALS['._pirogue-testing.session.notices.label']);

pirogue_test_execute('_init()', function () {
    if (!array_key_exists('._pirogue.session.notices.label', $GLOBALS)) {
        return 'variable ._pirogue.session.notices.label not initialized';
    } elseif ($GLOBALS['._pirogue-testing.session.notices.label'] != $GLOBALS['._pirogue.session.notices.label']) {
        return 'Variable ._pirogue.session.notices.label contains incorrect value.';
    } else {
        return '';
    }
});

pirogue_test_execute('_init()', function () {
    if (!array_key_exists($GLOBALS['._pirogue.session.notices.label'], $_SESSION)) {
        return 'Variable sessioned variable is not initialized';
    } elseif (!empty($_SESSION[$GLOBALS['._pirogue.session.notices.label']])) {
        return 'Variable sessioned variable contains values.';
    } else {
        return '';
    }
});

notices\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.session.notices.label', $GLOBALS) ? 'value not cleared.' : '');
unset($_SESSION);
