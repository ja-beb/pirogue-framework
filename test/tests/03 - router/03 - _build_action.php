<?php

/**
 * Testing pirogue\dispatcher\router\_build_action()
 * php version 8.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

function _router_get_action_test(string $controller_namespace, string $action_name, string $request_method, string $results): string
{
    $function_action = router\_build_action($controller_namespace, $action_name, $request_method);
    return $results == $function_action ? '' : sprintf('invalid action returned: returned "%s" but expected "%s"', $function_action, $results);
}

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', 'example-controller.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));

$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);

pirogue_test_execute('_build_action(): GET - example_controller/update', fn() => _router_get_action_test('example_controller', 'update', 'GET', ''));
pirogue_test_execute('_build_action(): GET - example_controller/index', fn() => _router_get_action_test('example_controller', 'index', 'GET', 'example_controller\index_get'));
pirogue_test_execute('_build_action(): POST - example_controller/index', fn() => _router_get_action_test('example_controller', 'index', 'POST', 'example_controller\index_post'));
pirogue_test_execute('_build_action(): POST - example_controller/fallback', fn() => _router_get_action_test('example_controller', 'fallback', 'POST', 'example_controller\fallback_get'));
router\_dispose();
