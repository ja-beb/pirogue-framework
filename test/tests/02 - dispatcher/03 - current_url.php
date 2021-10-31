<?php

/**
 * Testing url_current()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

<<<<<<< HEAD:test/tests/02 - dispatcher/04 - url_current.php
$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];

=======
>>>>>>> main:test/tests/02 - dispatcher/03 - current_url.php
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
