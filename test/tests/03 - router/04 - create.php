<?php

/**
 * Testing pirogue\dispatcher\router\register()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\router;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'router.php']));

$GLOBALS['._pirogue-testing.dispatcher.router.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', '%s.php']);
router\_init($GLOBALS['._pirogue-testing.dispatcher.router.path_format']);


function _router_test_create(array $route_result, array $route_expected): string
{
    $route = router\create('example-controller', 'index', 'GET');
    if ($route_result['controller_name'] != $route_expected['controller_name']) {
        return sprintf('invalid controller name: recieved="%s", expected="%s"', $route_result['controller_name'], $route_expected['controller_name']);
    }

    if ($route_result['action_name'] != $route_expected['action_name']) {
        return sprintf('invalid action name: recieved="%s", expected="%s"', $route_result['action_name'], $route_expected['action_name']);
    }

    if ($route_result['request_method'] != $route_expected['request_method']) {
        return sprintf('invalid request_method: recieved="%s", expected="%s"', $route_result['request_method'], $route_expected['request_method']);
    }

    if ($route_result['controller_path'] != $route_expected['controller_path']) {
        return sprintf('invalid controller path: recieved="%s", expected="%s"', $route_result['controller_path'], $route_expected['controller_path']);
    }

    if ($route_result['action'] != $route_expected['action']) {
        return sprintf('invalid action: recieved="%s", expected="%s"', $route_result['action'], $route_expected['action']);
    }

    return '';
}

pirogue_test_execute('create(): GET - example_controller\index', fn() => _router_test_create(
    router\create('example-controller', 'index', 'GET'),
    [
            'controller_name' => 'example-controller',
            'action_name' => 'index',
            'request_method' => 'GET',
            'controller_path' => '/pirogue/controller/example-controller.php',
            'action' => 'example_controller\index_get'
    ]
));

pirogue_test_execute('create(): POST - example_controller\index', fn() => _router_test_create(
    router\create('example-controller', 'index', 'POST'),
    [
            'controller_name' => 'example-controller',
            'action_name' => 'index',
            'request_method' => 'POST',
            'controller_path' => '/pirogue/controller/example-controller.php',
            'action' => 'example_controller\index_post'
    ]
));

pirogue_test_execute('create(): GET internal_controller\fallback', fn() => _router_test_create(
    router\create('internal-controller', 'fallback', 'GET', '_internal-controller'),
    [
            'controller_name' => 'internal-controller',
            'action_name' => 'fallback',
            'request_method' => 'GET',
            'controller_path' => '/pirogue/controller/_internal-controller.php',
            'action' => 'internal_controller\fallback_get'
    ]
));

pirogue_test_execute('create(): POST _internal-controller\fallback', fn() => _router_test_create(
    router\create('internal-controller', 'fallback', 'POST', '_internal-controller'),
    [
            'controller_name' => 'internal-controller',
            'action_name' => 'fallback',
            'request_method' => 'POST',
            'controller_path' => '/pirogue/controller/_internal-controller.php',
            'action' => 'internal_controller\fallback_get'
    ]
));

pirogue_test_execute('create(): GET invalid-controller\index', fn() => _router_test_create(
    router\create('invalid-controller', 'index', 'GET'),
    [
            'controller_name' => 'invalid-controller',
            'action_name' => 'index',
            'request_method' => 'GET',
            'controller_path' => '',
            'action' => ''
    ]
));

pirogue_test_execute('create(): GET example-controller\invalid-action', fn() => _router_test_create(
    router\create('example-controller', 'invalid-action', 'GET'),
    [
            'controller_name' => 'example-controller',
            'action_name' => 'invalid-action',
            'request_method' => 'GET',
            'controller_path' => '/pirogue/controller/example-controller.php',
            'action' => ''
    ]
));

router\_dispose();
