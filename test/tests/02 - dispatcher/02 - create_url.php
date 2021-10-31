<?php

/**
 * Testing url_create()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];

dispatcher\_init(
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    $GLOBALS['.pirogue-testing.dispatcher.request_data']
);

dispatcher\_init(
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    $GLOBALS['.pirogue-testing.dispatcher.request_data']
);

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query($GLOBALS['.pirogue-testing.dispatcher.request_data']),
);

pirogue_test_execute(sprintf('url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher\url_create(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        $GLOBALS['.pirogue-testing.dispatcher.request_data']
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path']
);
pirogue_test_execute(sprintf('url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher\url_create(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        []
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = $GLOBALS['.pirogue-testing.dispatcher.address'];
pirogue_test_execute(sprintf('url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher\url_create('', []);
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query(['list' => [ 'true', 'true', 'false']]),
);
pirogue_test_execute(sprintf('url_create(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher\url_create(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        ['list' => [ 'true', 'true', 'false']]
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

dispatcher\_dispose();
