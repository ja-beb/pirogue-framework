<?php

/**
 * Testing url()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\cdn;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'cdn.php']));

// set up testing environment.
cdn\_init([
    'script' => 'https://cdn.localhost.localdomain/script',
    'media' => 'https://cdn.localhost.localdomain/media',
    'font' => 'https://cdn.localhost.localdomain/font',
    'style' => 'https://cdn.localhost.localdomain/style',
]);

// run test.
pirogue_test_execute("url()", function () {
    $address_script = $GLOBALS['._pirogue-testing.cdn.servers']['script'] ?? '';
    return cdn\url('script')  == $address_script ? '' : 'Invalid url returned.';
});

// clean up test environment.
cdn\_dispose();
