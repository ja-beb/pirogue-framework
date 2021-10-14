<?php

/**
 * Testing pirogue_dispatcher_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'dispatcher.php']));
require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'dispatcher.php']));

pirogue_test_execute("pirogue_dispatcher_init(): \$GLOBALS['.pirogue.dispatcher.address']", function () {
    pirogue_dispatcher_init($GLOBALS['.pirogue-testing.dispatcher.address'], $GLOBALS['.pirogue-testing.dispatcher.request_path'], $GLOBALS['.pirogue-testing.dispatcher.request_data']);
    return $GLOBALS['.pirogue-testing.dispatcher.address'] == $GLOBALS['.pirogue.dispatcher.address'] ? '' : 'invalid value.';
});

pirogue_test_execute("pirogue_dispatcher_init(): \$GLOBALS['.pirogue.dispatcher.request_path']", function () {
    pirogue_dispatcher_init($GLOBALS['.pirogue-testing.dispatcher.address'], $GLOBALS['.pirogue-testing.dispatcher.request_path'], $GLOBALS['.pirogue-testing.dispatcher.request_data']);
    return $GLOBALS['.pirogue-testing.dispatcher.request_path'] == $GLOBALS['.pirogue.dispatcher.request_path'] ? '' : 'invalid value.';
});

pirogue_test_execute("pirogue_dispatcher_init(): \$GLOBALS['.pirogue.dispatcher.request_data']", function () {
    pirogue_dispatcher_init($GLOBALS['.pirogue-testing.dispatcher.address'], $GLOBALS['.pirogue-testing.dispatcher.request_path'], $GLOBALS['.pirogue-testing.dispatcher.request_data']);
    return $GLOBALS['.pirogue-testing.dispatcher.request_data'] == $GLOBALS['.pirogue.dispatcher.request_data'] ? '' : 'invalid value.';
});
