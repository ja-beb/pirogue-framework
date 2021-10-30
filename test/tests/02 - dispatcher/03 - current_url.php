<?php

/**
 * Testing url_current()
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

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query($GLOBALS['.pirogue-testing.dispatcher.request_data'])
);

pirogue_test_execute('url_current()', function () {
    $url = dispatcher\url_current();
    return $url == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s" - expecting "%s"', $url, $GLOBALS['._pirogue-testing.dispatcher.url']);
});

dispatcher\_dispose();
