<?php

/**
 * Testing dispatcher_callback_parse()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\dispatcher_init;
use function pirogue\dispatcher_callback_parse;
use function pirogue\dispatcher_url_current;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'dispatcher.php']));


dispatcher_init(
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    $GLOBALS['.pirogue-testing.dispatcher.request_data']
);

pirogue_test_execute(sprintf('dispatcher_callback_parse(): %s', dispatcher_url_current()), function () {
    $callback = urlencode(dispatcher_url_current());
    dispatcher_callback_parse($callback);
    return dispatcher_callback_parse($callback) == dispatcher_url_current()
        ? ''
        : 'invalid return value';
});
