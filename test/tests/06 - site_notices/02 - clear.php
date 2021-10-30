<?php

/**
 * Testing for clear().
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

pirogue_test_execute('clear()', function () {
    $_SESSION[_PIROGUE_TESTING_SITE_NOTICES_LABEL] = $GLOBALS['.pirogue-testing.session_notices.notices'];
    $list = site_notices\clear();
    if (!empty($_SESSION[_PIROGUE_TESTING_SITE_NOTICES_LABEL])) {
        return '00 - site notices were not cleared.';
    } elseif ($list != $GLOBALS['.pirogue-testing.session_notices.notices']) {
        return '01 - wrong site notices were returned.';
    } else {
        return '';
    }
});
site_notices\_dispose();
