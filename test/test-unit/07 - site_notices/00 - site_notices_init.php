<?php

/**
 * Testing for pirogue_site_notices_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'site_notices.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'site_notices.php']));

// test pirogue_site_notices_init(string $index): $GLOBALS['._pirogue.site_notices.index'] is properly initialized
pirogue_test_execute("pirogue_site_notices_init(): \$GLOBALS['._pirogue.site_notices.index']", function () {
    pirogue_site_notices_init(_PIROGUE_TESTING_SITE_NOTICES_LABEL);
    if (!array_key_exists('._pirogue.site_notices.index', $GLOBALS)) {
        return "Variable \$GLOBALS['._pirogue.site_notices.index'] not initialized";
    } elseif (_PIROGUE_TESTING_SITE_NOTICES_LABEL != $GLOBALS['._pirogue.site_notices.index']) {
        return "Variable \$GLOBALS['._pirogue.site_notices.index'] contains incorrect value.";
    } else {
        return '';
    }
});

// test pirogue_site_notices_init(string $index): $_SESSION[$GLOBALS['._pirogue.site_notices.index']] is properly initialized
pirogue_test_execute("pirogue_site_notices_init(): \$_SESSION[\$GLOBALS['._pirogue.site_notices.index']]", function () {
    $_SESSION = [];
    pirogue_site_notices_init(_PIROGUE_TESTING_SITE_NOTICES_LABEL);
    if (!array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION)) {
        return "Variable \$_SESSION[\$GLOBALS['._pirogue.site_notices.index']] is not initialized";
    } elseif (!empty($_SESSION[$GLOBALS['._pirogue.site_notices.index']])) {
        return "Variable \$_SESSION[\$GLOBALS['._pirogue.site_notices.index']] contains values.";
    } else {
        return '';
    }
});
