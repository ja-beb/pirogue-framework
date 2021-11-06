<?php

/**
 * Testing pirogue\dispatcher_route_current()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;
use function pirogue\dispatcher_route_register;
use function pirogue\dispatcher_route_create;
use function pirogue\dispatcher_route_current;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

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

pirogue_test_execute('pirogue\dispatcher_route_current()', function () {
    $route = dispatcher_route_create('namespace', 'action', 'method');
    dispatcher_route_register($route);

    $route = dispatcher_route_create('namespace2', 'action', 'method');
    dispatcher_route_register($route);

    $regsitered_route = dispatcher_route_current();
    if (null == $regsitered_route) {
        return 'route not registered';
    } elseif ($regsitered_route != $route) {
        return 'invalid route saved';
    } else {
        return '';
    }
});
_dispatcher_dispose();
