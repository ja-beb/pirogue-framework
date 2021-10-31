<?php

/**
 * Testing callback_parse()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'dispatcher.php']));


dispatcher\_init(
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    $GLOBALS['.pirogue-testing.dispatcher.request_data']
);

pirogue_test_execute('callback_parse()', function () {
    $callback = urlencode(dispatcher\url_current());
    dispatcher\callback_parse($callback);
    return dispatcher\callback_parse($callback) == dispatcher\url_current()
        ? ''
        : 'invalid return value';
});
dispatcher\_dispose();
