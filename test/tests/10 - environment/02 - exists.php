<?php

/**
 * Test pirogue\session\environment\exists().
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

pirogue_test_execute('exists(): verify values not in array are not returned.', fn() => environment\exists('@test-index') ? 'returned exists = true on empty array' : '');
pirogue_test_execute('exists(): verify values are exist after being set. ', function () {
    $_SESSION[$GLOBALS['._pirogue.session.environment.label']]['@test-index'] = 'texst-value';
    return environment\exists('@test-index') ? '' : 'does not find return exists=true';
});

// clean up testing.
environment\_dispose();
unset($_SESSION);
