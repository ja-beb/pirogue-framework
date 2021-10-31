<?php

/**
 * Testing for _init() && _dispose.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use pirogue\site_notices;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'site_notices.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'site_notices.php']));

$_SESSION = [];
site_notices\_init(_PIROGUE_TESTING_SITE_NOTICES_LABEL);
pirogue_test_execute('_init()', function () {
    if (!array_key_exists('._pirogue.site_notices.index', $GLOBALS)) {
        return 'variable ._pirogue.site_notices.index not initialized';
    } elseif (_PIROGUE_TESTING_SITE_NOTICES_LABEL != $GLOBALS['._pirogue.site_notices.index']) {
        return 'Variable ._pirogue.site_notices.index contains incorrect value.';
    } else {
        return '';
    }
});

pirogue_test_execute('_init()', function () {
    if (!array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION)) {
        return 'Variable sessioned variable is not initialized';
    } elseif (!empty($_SESSION[$GLOBALS['._pirogue.site_notices.index']])) {
        return 'Variable sessioned variable contains values.';
    } else {
        return '';
    }
});

site_notices\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.site_notices.index', $GLOBALS) ? 'value not cleared.' : '');
unset($_SESSION);
