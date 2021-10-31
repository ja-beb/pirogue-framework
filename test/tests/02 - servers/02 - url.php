<?php

/**
 * Testing pirogue\dispatcher\servers\url()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\servers;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'servers.php']));
$GLOBALS['._pirogue-testing.dispatcher.servers.list'] = [
    'cdn' => 'https://cdn.localhost.localdomain/script',
    'site' => 'https://localhost.localdomain/media',
    'api' => 'https://api.localhost.localdomain',
];
servers\_init();

// run test.
pirogue_test_execute("url()", fn() => servers\url('cdn')  == ($GLOBALS['._pirogue-testing.servers.list']['cdn'] ?? '') ? '' : 'Invalid url returned.');

// clean up test environment.
servers\_dispose();
