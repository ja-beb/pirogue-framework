<?php

/**
 * Testing pirogue\dispatcher\servers\_init() && pirogue\dispatcher\servers\_dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\servers;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'servers.php']));
servers\_init(['site' => 'https://localhost.local']);

pirogue_test_execute('_init()', function () {
    if (!array_key_exists('._pirogue.dispatcher.servers.list', $GLOBALS)) {
        return 'server list is not initialized.';
    } elseif (!is_array($GLOBALS['._pirogue.dispatcher.servers.list'])) {
        return 'server list is not an array.';
    } else {
        return '';
    }
});

servers\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.dispatcher.servers.list', $GLOBALS) ? 'server list is not properly disposed of.' : '');
