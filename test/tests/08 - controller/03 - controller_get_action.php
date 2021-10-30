<?php

/**
 * Testing controller_get_action()
 * php version 8.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_init;
use function pirogue\controller_get_action;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', 'testing-access.php']));

function _controller_get_action_test(string $action, string $method, string $results): string
{
    $action = controller_get_action($action, $method);
    return $results == $action ? '' : sprintf('invalid action returned: returned "%s" but expected "%s"', $action, $results);
}

controller_init('testing-access');
pirogue_test_execute("controller_get_action(): testing_access_update_get", function () {
    return _controller_get_action_test('update', 'GET', '');
});

pirogue_test_execute("controller_get_action(): testing_access_index_get", function () {
    return _controller_get_action_test('index', 'GET', 'testing_access\index_get');
});

pirogue_test_execute("controller_get_action(): testing_access_index_post", function () {
    return _controller_get_action_test('index', 'POST', 'testing_access\index_post');
});

pirogue_test_execute("controller_get_action(): testing_access_fallback_post", function () {
    return _controller_get_action_test('fallback', 'POST', 'testing_access\fallback_get');
});
