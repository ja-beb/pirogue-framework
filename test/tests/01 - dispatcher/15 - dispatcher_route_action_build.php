<?php

/**
 * Testing pirogue\dispatcher_route_action_build()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;
use function pirogue\dispatcher_route_action_build;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', 'example-controller.php']));

$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];
$GLOBALS['._pirogue-testing.dispatcher_route.path_format'] = './controllers/%s.php';

_dispatcher_init(
    address:$GLOBALS['.pirogue-testing.dispatcher.address'],
    request_path:$GLOBALS['.pirogue-testing.dispatcher.request_path'],
    request_data:$GLOBALS['.pirogue-testing.dispatcher.request_data'],
    controller_path_format:$GLOBALS['._pirogue-testing.dispatcher_route.path_format'],
);

pirogue_test_execute('pirogue\dispatcher_route_action_build(): valid get', function () {
    $action = dispatcher_route_action_build('example_controller', 'index', 'get');
    return 'example_controller\index_get' == $action ? '' : sprintf('returned invalid action: "%s"', $action);
});

pirogue_test_execute('pirogue\dispatcher_route_action_build(): valid post', function () {
    $action = dispatcher_route_action_build('example_controller', 'index', 'post');
    return 'example_controller\index_post' == $action ? '' : sprintf('returned invalid action: "%s"', $action);
});

pirogue_test_execute('pirogue\dispatcher_route_action_build(): invalid get', function () {
    $action = dispatcher_route_action_build('example_controller', 'no_route', 'get');
    return '' == $action ? '' : sprintf('returned invalid action: "%s"', $action);
});

pirogue_test_execute('pirogue\dispatcher_route_action_build(): invalid post', function () {
    $action = dispatcher_route_action_build('example_controller', 'no_route', 'post');
    return '' == $action ? '' : sprintf('returned invalid action: "%s"', $action);
});

_dispatcher_dispose();