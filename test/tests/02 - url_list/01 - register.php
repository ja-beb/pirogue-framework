<?php

/**
 * Testing pirogue\dispatcher\url_list\register()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\url_list;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'url_list.php']));
$GLOBALS['._pirogue-testing.dispatcher.url_list.list'] = [
    'cdn' => 'https://cdn.localhost.localdomain/script',
    'site' => 'https://localhost.localdomain/media',
    'api' => 'https://api.localhost.localdomain/font',
];
url_list\_init();

pirogue_test_execute('register()', function () {
    foreach ($GLOBALS['._pirogue-testing.dispatcher.url_list.list'] as $name => $address) {
        url_list\register($name, $address);
    }

    return $GLOBALS['._pirogue-testing.dispatcher.url_list.list'] == $GLOBALS['._pirogue.dispatcher.url_list.list']
        ? ''
        : 'url_list not regsitered';
});
url_list\_dispose();
