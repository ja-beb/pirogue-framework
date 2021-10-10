<?php

/**
 * Testing for site_notices_clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'site_notices.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'site_notices.php']));

// test site_notices_clear():
pirogue_test_execute("pirogue_site_notices_clear()", function () {
    $_SESSION = [];
    pirogue_site_notices_init(_PIROGUE_TESTING_SITE_NOTICES_LABEL);
    $_SESSION[_PIROGUE_TESTING_SITE_NOTICES_LABEL] = $GLOBALS['.pirogue-testing.session_notices.notices'];
    $list = pirogue_site_notices_clear();
    if (!empty($_SESSION[_PIROGUE_TESTING_SITE_NOTICES_LABEL])) {
        return ['00 - site notices were not cleared.'];
    } elseif ($list != $GLOBALS['.pirogue-testing.session_notices.notices']) {
        return ['01 - wrong site notices were returned.'];
    } else {
        return [];
    }
});
