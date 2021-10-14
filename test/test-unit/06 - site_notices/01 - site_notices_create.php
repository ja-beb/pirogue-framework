<?php

/**
 * Testing for pirogue_site_notices_create().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'site_notices.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'site_notices.php']));

// test pirogue_site_notices_init(string $index)
pirogue_test_execute("pirogue_site_notices_create()", function () {
    $_SESSION = [];
    pirogue_site_notices_init(_PIROGUE_TESTING_SITE_NOTICES_LABEL);

    // load test messages.
    foreach ($GLOBALS['.pirogue-testing.session_notices.notices'] as $notice) {
        pirogue_site_notices_create($notice[0], $notice[1]);
    }

    // test contents of saved site notices.
    if (empty($_SESSION[$GLOBALS['._pirogue.site_notices.index']])) {
        return '00 - no site notices exist.';
    } elseif ($GLOBALS['.pirogue-testing.session_notices.notices'] != $_SESSION[$GLOBALS['._pirogue.site_notices.index']]) {
        return '01 - site notice list does not match.';
    } else {
        return '';
    }
});
