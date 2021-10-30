<?php

/**
 * Testing _init() and _dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'dispatcher.php']));

dispatcher\_init($GLOBALS['.pirogue-testing.dispatcher.address'], $GLOBALS['.pirogue-testing.dispatcher.request_path'], $GLOBALS['.pirogue-testing.dispatcher.request_data']);
pirogue_test_execute('_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.address'] == $GLOBALS['.pirogue.dispatcher.address'] ? '' : 'invalid value for .pirogue-testing.dispatcher.address.');
pirogue_test_execute('_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.request_path'] == $GLOBALS['.pirogue.dispatcher.request_path'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_path.');
pirogue_test_execute('_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.request_data'] == $GLOBALS['.pirogue.dispatcher.request_data'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_data.');

dispatcher\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('.pirogue.dispatcher.address', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.address.' : '');
pirogue_test_execute('_dispose()', fn() => array_key_exists('.pirogue.dispatcher.request_path', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.request_path.' : '');
pirogue_test_execute('_dispose()', fn() => array_key_exists('.pirogue.dispatcher.request_data', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.request_data.' : '');
