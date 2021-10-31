<?php

/**
 * Test clear().
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


pirogue_test_execute('clear() - verify return value.', function () {
    $environment = [
        '@test-index' => 'test-value',
        '@test-number' => 3.14,
        '#test-array' => ['apples', 'oranges'],
        '!test-object' => new StdClass(),
    ];
    $_SESSION[$GLOBALS['._pirogue.session.environment.label']] = $environment;

    // clear and check if return equals set values.
    return environment\clear() != $environment ?  'Returned variables do not match initial state.' : '';
});

pirogue_test_execute('clear(): value not cleard.', fn() => empty($_SESSION[$GLOBALS['._pirogue.session.environment.label']]) ? '' : 'Registered variables did not cleared.');

// clean up enviroment
environment\_dispose();
unset($_SESSION);
