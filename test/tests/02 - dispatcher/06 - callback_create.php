<?php

/**
 * Testing dispatcher_callback_create()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\dispatcher\_init;
use function pirogue\dispatcher\_finalize;
use function pirogue\dispatcher\callback_create;
use function pirogue\dispatcher\url_current;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'dispatcher.php']));


_init(
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    $GLOBALS['.pirogue-testing.dispatcher.request_data']
);

pirogue_test_execute(sprintf('callback_create(): %s', url_current()), function () {
    return callback_create(url_current()) == urlencode(url_current())
        ? ''
        : 'invalid return value';
});
_finalize();
