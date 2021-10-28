<?php

/**
 * Testing controller_has_access()
 * php version 8.0.controller_get_action
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_init;
use function pirogue\controller_get_action;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', 'testing.php']));

function _controller_get_action_test(string $action, string $method, string $results): string
{
    $action = controller_get_action($action, $method);
    return $results == $action ? '' : sprintf('invalid action returned: returned "%s" but expected "%s"', $action, $results);
}

controller_init('testing');
pirogue_test_execute("controller_has_access(): testing_update_get", function () {
    return _controller_get_action_test('update', 'GET', '');
});

pirogue_test_execute("controller_has_access(): testing_index_get", function () {
    return _controller_get_action_test('index', 'GET', 'testing_index_get');
});

pirogue_test_execute("controller_has_access(): testing_index_post", function () {
    return _controller_get_action_test('index', 'POST', 'testing_index_post');
});

pirogue_test_execute("controller_has_access(): testing_fallback_post", function () {
    return _controller_get_action_test('fallback', 'POST', 'testing_fallback_get');
});
