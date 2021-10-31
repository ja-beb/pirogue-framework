<?php

/**
<<<<<<< HEAD
 * Testing pirogue\dispatcher\_init() and pirogue\dispatcher\_dispose()
=======
 * Testing _init() and _dispose()
>>>>>>> main
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
<<<<<<< HEAD

// test _init()
$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];
=======
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'dispatcher.php']));

>>>>>>> main
dispatcher\_init($GLOBALS['.pirogue-testing.dispatcher.address'], $GLOBALS['.pirogue-testing.dispatcher.request_path'], $GLOBALS['.pirogue-testing.dispatcher.request_data']);
pirogue_test_execute('_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.address'] == $GLOBALS['.pirogue.dispatcher.address'] ? '' : 'invalid value for .pirogue-testing.dispatcher.address.');
pirogue_test_execute('_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.request_path'] == $GLOBALS['.pirogue.dispatcher.request_path'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_path.');
pirogue_test_execute('_init()', fn() => $GLOBALS['.pirogue-testing.dispatcher.request_data'] == $GLOBALS['.pirogue.dispatcher.request_data'] ? '' : 'invalid value for .pirogue-testing.dispatcher.request_data.');

<<<<<<< HEAD
// test _dispose()
=======
>>>>>>> main
dispatcher\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('.pirogue.dispatcher.address', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.address.' : '');
pirogue_test_execute('_dispose()', fn() => array_key_exists('.pirogue.dispatcher.request_path', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.request_path.' : '');
pirogue_test_execute('_dispose()', fn() => array_key_exists('.pirogue.dispatcher.request_data', $GLOBALS) ? 'not removed: .pirogue-testing.dispatcher.request_data.' : '');
