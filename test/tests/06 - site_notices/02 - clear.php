<?php

/**
 * Testing for clear().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\site_notices\_init;
use function pirogue\site_notices\_dispose;
use function pirogue\site_notices\clear;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'site_notices.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'site_notices.php']));

pirogue_test_execute("clear()", function () {
    $_SESSION = [];
    _init(_PIROGUE_TESTING_SITE_NOTICES_LABEL);
    $_SESSION[_PIROGUE_TESTING_SITE_NOTICES_LABEL] = $GLOBALS['.pirogue-testing.session_notices.notices'];
    $list = clear();
    if (!empty($_SESSION[_PIROGUE_TESTING_SITE_NOTICES_LABEL])) {
        return '00 - site notices were not cleared.';
    } elseif ($list != $GLOBALS['.pirogue-testing.session_notices.notices']) {
        return '01 - wrong site notices were returned.';
    } else {
        return '';
    }
});
