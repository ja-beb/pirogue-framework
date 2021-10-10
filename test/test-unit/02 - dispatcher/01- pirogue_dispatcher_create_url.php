<?php

/**
 * Testing pirogue_dispatcher_create_url()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'dispatcher.php']));

pirogue_test_execute("pirogue_dispatcher_create_url(): \$GLOBALS['.pirogue.dispatcher.address']", function () {
    $url = sprintf(
        '%s/%s?%s',
        $GLOBALS['.pirogue-testing.dispatcher.address'],
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        http_build_query($GLOBALS['.pirogue-testing.dispatcher.request_data']),
    );
    $url_build = pirogue_dispatcher_create_url(
        $GLOBALS['.pirogue-testing.dispatcher.request_path'],
        $GLOBALS['.pirogue-testing.dispatcher.request_data']
    );
    return  $url_build == $url ? [] : ['invalid url returned.'];
});
