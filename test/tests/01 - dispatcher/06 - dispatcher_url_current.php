<?php

/**
 * Testing pirogue\dispatcher_url_current()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;
use function pirogue\dispatcher_url_current;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];
$GLOBALS['._pirogue-testing.dispatcher_route.path_format'] = './controllers/%s.php';

pirogue\_dispatcher_init(
    address:$GLOBALS['.pirogue-testing.dispatcher.address'],
    request_path:$GLOBALS['.pirogue-testing.dispatcher.request_path'],
    request_data:$GLOBALS['.pirogue-testing.dispatcher.request_data'],
    controller_path_format:$GLOBALS['._pirogue-testing.dispatcher_route.path_format'],
);

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query($GLOBALS['.pirogue-testing.dispatcher.request_data'])
);

pirogue_test_execute('pirogue\dispatcher_url_current()', function () {
    $url = dispatcher_url_current();
    return $url == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s" - expecting "%s"', $url, $GLOBALS['._pirogue-testing.dispatcher.url']);
});

_dispatcher_dispose();
