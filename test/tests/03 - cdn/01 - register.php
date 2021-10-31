<?php

/**
 * Testing pirogue\dispatcher\cdn\register()
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

pirogue_test_execute('register()', function () {
    foreach ($GLOBALS['._pirogue-testing.dispatcher.cdn.servers'] as $name => $address) {
        cdn\register($name, $address);
    }

    return $GLOBALS['._pirogue-testing.dispatcher.cdn.servers'] == $GLOBALS['._pirogue.dispatcher.cdn.servers']
        ? ''
        : 'servers not regsitered';
});
cdn\_dispose();
