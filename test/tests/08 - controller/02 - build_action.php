<?php

/**
 * Testing build_action()
 * php version 8.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller\_init;
use function pirogue\controller\build_action;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', 'example-controller.php']));

function _controller_get_action_test(string $controller_name, string $action_name, string $request_method, string $results): string
{
    $function_action = build_action($controller_name, $action_name, $request_method);
    return $results == $function_action ? '' : sprintf('invalid action returned: returned "%s" but expected "%s"', $function_action, $results);
}

_init('example-controller');
pirogue_test_execute("build_action(): testing_access_update_get", function () {
    return _controller_get_action_test('example-controller', 'update', 'GET', '');
});

pirogue_test_execute("build_action(): testing_access_index_get", function () {
    return _controller_get_action_test('example-controller', 'index', 'GET', 'example_controller\index_get');
});

pirogue_test_execute("build_action(): testing_access_index_post", function () {
    return _controller_get_action_test('example-controller', 'index', 'POST', 'example_controller\index_post');
});

pirogue_test_execute("build_action(): testing_access_fallback_post", function () {
    return _controller_get_action_test('example-controller', 'fallback', 'POST', 'example_controller\fallback_get');
});
