<?php

/**
 * Testing pirogue\dispatcher_controller_path_build()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;
use function pirogue\dispatcher_controller_path_build;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];
$GLOBALS['._pirogue-testing.dispatcher_route.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controller', '%s.php']);

_dispatcher_init(
    address:$GLOBALS['.pirogue-testing.dispatcher.address'],
    request_path:$GLOBALS['.pirogue-testing.dispatcher.request_path'],
    request_data:$GLOBALS['.pirogue-testing.dispatcher.request_data'],
    controller_path_format:$GLOBALS['._pirogue-testing.dispatcher_route.path_format'],
);

pirogue_test_execute('pirogue\dispatcher_controller_path_build(): valid', function () {
    $path = dispatcher_controller_path_build(['example-controller']);
    return '/pirogue/controller/example-controller.php' == $path ? '' : sprintf('invalid controller returned: "%s".', $path);
});

pirogue_test_execute('pirogue\dispatcher_controller_path_build(): valid', function () {
    $path = dispatcher_controller_path_build(['users', 'edit']);
    return '/pirogue/controller/users/edit.php' == $path ? '' : sprintf('invalid controller returned: "%s".', $path);
});

pirogue_test_execute('pirogue\dispatcher_controller_path_build(): valid', function () {
    $path = dispatcher_controller_path_build(['users', 'invalid-controller']);
    return '' == $path ? '' : sprintf('invalid controller returned: "%s".', $path);
});

_dispatcher_dispose();
