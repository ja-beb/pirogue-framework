<?php

/**
 * Testing _init() && _dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\cdn;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'cdn.php']));

pirogue_test_execute('_init()', function () {
    cdn\_init();
    if (!array_key_exists('._pirogue.cdn.servers', $GLOBALS)) {
        return 'server list is not initialized.';
    } elseif (!is_array($GLOBALS['._pirogue.cdn.servers'])) {
        return 'server list is not an array.';
    } else {
        return '';
    }
});

pirogue_test_execute('_dispose()', function () {
    $GLOBALS['._pirogue.cdn.servers'] = ['one' => 'example'];
    cdn\_dispose();
    return array_key_exists('._pirogue.cdn.servers', $GLOBALS) ? 'server list is not properly disposed of.' : '';
});
unset($GLOBALS['._pirogue.cdn.servers']);
