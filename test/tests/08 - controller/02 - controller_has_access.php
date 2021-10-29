<?php

/**
 * Testing controller_has_access()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_init;
use function pirogue\controller_has_access;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', 'testing-access.php']));

$GLOBALS['.pirogue-testing.testing-access.default_access'] = false;
controller_init('testing-access', $GLOBALS['.pirogue-testing.testing-access.default_access']);
pirogue_test_execute("controller_has_access(): testing-access() - return controller default.", function () {
    return $GLOBALS['.pirogue-testing.testing-access.default_access'] == controller_has_access(null) ? '' : 'invalid access returned';
});

controller_init('testing-access');
pirogue_test_execute("controller_has_access(): testing_has_access() - with user id", function () {
    return controller_has_access(1) ? '' : 'invalid access returned';
});

pirogue_test_execute("controller_has_access(): testing_has_access() - without user id", function () {
    return $GLOBALS['.pirogue-testing.testing-access.default_access'] == controller_has_access(null) ? 'invalid access returned' : '';
});
