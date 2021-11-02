<?php

/**
 * Testing pirogue\dispatcher\url_list\get()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\url_list;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'url_list.php']));
$GLOBALS['._pirogue-testing.dispatcher.url_list.list'] = [
    'cdn' => 'https://cdn.localhost.localdomain/script',
    'site' => 'https://localhost.localdomain/media',
    'api' => 'https://api.localhost.localdomain',
];
url_list\_init();

// run test.
pirogue_test_execute("get()", fn() => url_list\get('cdn')  == ($GLOBALS['._pirogue-testing.url_list.list']['cdn'] ?? '') ? '' : 'Invalid url returned.');

// clean up test environment.
url_list\_dispose();
