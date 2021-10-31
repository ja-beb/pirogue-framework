<?php

/**
 * Testing pirogue\dispatcher\cdn\url()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\cdn;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'cdn.php']));
$GLOBALS['._pirogue-testing.dispatcher.cdn.servers'] = [
    'script' => 'https://cdn.localhost.localdomain/script',
    'media' => 'https://cdn.localhost.localdomain/media',
    'font' => 'https://cdn.localhost.localdomain/font',
    'style' => 'https://cdn.localhost.localdomain/style',
];
cdn\_init();

// run test.
pirogue_test_execute("url()", fn() => cdn\url('script')  == ($GLOBALS['._pirogue-testing.cdn.servers']['script'] ?? '') ? '' : 'Invalid url returned.');

// clean up test environment.
cdn\_dispose();
