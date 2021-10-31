<?php

/**
 * Testing pirogue\dispatcher\servers\register()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\servers;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'servers.php']));
$GLOBALS['._pirogue-testing.dispatcher.servers.list'] = [
    'cdn' => 'https://cdn.localhost.localdomain/script',
    'site' => 'https://localhost.localdomain/media',
    'api' => 'https://api.localhost.localdomain/font',
];
servers\_init();

pirogue_test_execute('register()', function () {
    foreach ($GLOBALS['._pirogue-testing.dispatcher.servers.list'] as $name => $address) {
        servers\register($name, $address);
    }

    return $GLOBALS['._pirogue-testing.dispatcher.servers.list'] == $GLOBALS['._pirogue.dispatcher.servers.list']
        ? ''
        : 'servers not regsitered';
});
servers\_dispose();
