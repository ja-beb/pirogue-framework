<?php

/**
 * Testing pirogue\dispatcher_path_register()
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;
use function pirogue\dispatcher_path_register;

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

pirogue_test_execute('pirogue\dispatcher_path_register()', function () {
    dispatcher_path_register('cdn', 'https://cdn.locahost');
    if (!array_key_exists('cdn', $GLOBALS['._pirogue.dispatcher.path_list'])) {
        return 'path value not set';
    } elseif ('https://cdn.locahost' != $GLOBALS['._pirogue.dispatcher.path_list']['cdn']) {
        return 'path value set to incorrect value';
    } else {
        return '';
    }
});

_dispatcher_dispose();
