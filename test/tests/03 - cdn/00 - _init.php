<?php

/**
 * Testing pirogue\dispatcher\_init() && pirogue\dispatcher\_dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\dispatcher\cdn;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher', 'cdn.php']));
cdn\_init(['script' => 'https://script.localhost.local']);

pirogue_test_execute('_init()', function () {
    if (!array_key_exists('._pirogue.dispatcher.cdn.servers', $GLOBALS)) {
        return 'server list is not initialized.';
    } elseif (!is_array($GLOBALS['._pirogue.dispatcher.cdn.servers'])) {
        return 'server list is not an array.';
    } else {
        return '';
    }
});

cdn\_dispose();
pirogue_test_execute('_dispose()', fn() => array_key_exists('._pirogue.dispatcher.cdn.servers', $GLOBALS) ? 'server list is not properly disposed of.' : '');
