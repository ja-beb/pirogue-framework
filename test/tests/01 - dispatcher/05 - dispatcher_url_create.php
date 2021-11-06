<?php

/**
 * Testing pirogue\dispatcher_url_create()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_init;
use function pirogue\_dispatcher_dispose;
use function pirogue\dispatcher_url_create;

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


$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path']
);
pirogue_test_execute(sprintf('pirogue\dispatcher_url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_url_create(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        []
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path']
);
pirogue_test_execute(sprintf('pirogue\dispatcher_url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_url_create(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        []
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = $GLOBALS['.pirogue-testing.dispatcher.address'];
pirogue_test_execute(sprintf('pirogue\dispatcher_url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_url_create('', []);
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query(['list' => [ 'true', 'true', 'false']]),
);

pirogue_test_execute(sprintf('pirogue\dispatcher_url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_url_create(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        ['list' => [ 'true', 'true', 'false']]
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

_dispatcher_dispose();
