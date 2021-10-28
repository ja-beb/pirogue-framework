<?php

/**
 * Testing dispatcher_create_url()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

 use function pirogue\dispatcher_create_url;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'dispatcher.php']));

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query($GLOBALS['.pirogue-testing.dispatcher.request_data']),
);
pirogue_test_execute(sprintf('dispatcher_create_url(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_create_url(
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
pirogue_test_execute(sprintf('dispatcher_create_url(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_create_url(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        []
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = $GLOBALS['.pirogue-testing.dispatcher.address'];
pirogue_test_execute(sprintf('dispatcher_create_url(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_create_url(
        '',
        []
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});

$GLOBALS['._pirogue-testing.dispatcher.url'] = sprintf(
    '%s/%s?%s',
    $GLOBALS['.pirogue-testing.dispatcher.address'],
    $GLOBALS['.pirogue-testing.dispatcher.request_path'],
    http_build_query(['list' => [ 'true', 'true', 'false']]),
);
pirogue_test_execute(sprintf('dispatcher_create_url(): "%s"', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url_build = dispatcher_create_url(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        ['list' => [ 'true', 'true', 'false']]
    );
    return  $url_build == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url_build);
});
