<?php

/**
 * Testing pirogue\_dispatcher_init() and pirogue\_dispatcher_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;

require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']);

// test _init()
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

// check variable state - is initialized
pirogue_test_execute('_dispatcher_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.address'] == $GLOBALS['.pirogue.dispatcher.address'] ? '' : 'invalid value for .pirogue-testing.dispatcher.address.');
pirogue_test_execute('_dispatcher_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.request_path'] == $GLOBALS['.pirogue.dispatcher.request_path'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_path.');
pirogue_test_execute('_dispatcher_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.request_data'] == $GLOBALS['.pirogue.dispatcher.request_data'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_data.');
pirogue_test_execute('_dispatcher_init()', fn() => $GLOBALS['._pirogue-testing.dispatcher_route.path_format'] == $GLOBALS['._pirogue.dispatcher_route.path_format'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_data.');
pirogue_test_execute('_dispatcher_init()', fn() => array_key_exists('._pirogue.dispatcher_route.path_format', $GLOBALS) ? '' : 'variable ._pirogue.dispatcher_route.path_format is not set.');
pirogue_test_execute('_dispatcher_init()', fn() => array_key_exists('._pirogue.dispatcher.path_list', $GLOBALS) ? '' : 'variable ._pirogue.dispatcher.path_list is not set.');
pirogue_test_execute('_dispatcher_init()', fn() => array_key_exists('._pirogue.dispatcher.call_stack', $GLOBALS) ? '' : 'variable ._pirogue.dispatcher.call_stack is not set.');

// test _dispose()
_dispatcher_dispose();
pirogue_test_execute('_dispatcher_dispose()', fn() => array_key_exists('.pirogue.dispatcher.address', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.address.' : '');
pirogue_test_execute('_dispatcher_dispose()', fn() => array_key_exists('.pirogue.dispatcher.request_path', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.request_path.' : '');
pirogue_test_execute('_dispatcher_dispose()', fn() => array_key_exists('.pirogue.dispatcher.request_data', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.request_data.' : '');
pirogue_test_execute('_dispatcher_dispose()', fn() => array_key_exists('._pirogue.dispatcher_route.path_format', $GLOBALS) ? 'not removed: ._pirogue.dispatcher_route.path_format.' : '');
pirogue_test_execute('_dispatcher_dispose()', fn() => array_key_exists('._pirogue.dispatcher_route.path_list', $GLOBALS) ? 'not removed: ._pirogue.dispatcher_route.path_list.' : '');
pirogue_test_execute('_dispatcher_dispose()', fn() => array_key_exists('._pirogue.dispatcher_route.call_stack', $GLOBALS) ? 'not removed: ._pirogue.dispatcher_route.call_stack.' : '');
