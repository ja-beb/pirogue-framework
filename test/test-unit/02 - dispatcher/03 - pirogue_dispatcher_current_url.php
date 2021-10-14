<?php

/**
 * Testing pirogue_dispatcher_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

$GLOBALS['._pirogue-testing.dispatcher.url'] = pirogue_dispatcher_create_url(
    $GLOBALS['.pirogue.dispatcher.request_path'],
    $GLOBALS['.pirogue.dispatcher.request_data']
);
pirogue_test_execute(sprintf('pirogue_dispatcher_current_url(): %s', $GLOBALS['._pirogue-testing.dispatcher.url']), function () {
    $url = pirogue_dispatcher_current_url();
    return $url == $GLOBALS['._pirogue-testing.dispatcher.url'] ? '' : sprintf('invalid url returned "%s"', $url);
});
