<?php

/**
 * Testing \pirogue\database\mysqli\_get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

// set up testing environment
mysqli\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

function _test_mysqli_get(string $label): ?\mysqli
{
    try {
        return mysqli\_get($label);
    } catch (Throwable) {
        return null;
    }
}

pirogue_test_execute('_get(): invalid label', fn()  => null == _test_mysqli_get('invalid-website') ? '' : 'loaded invalid connection.');
pirogue_test_execute('_get(): valid label', fn()  => null == _test_mysqli_get('website') ? 'unable to load connection "website".' : '');
pirogue_test_execute('_get(): valid label, invalid connection info', fn()  => null == _test_mysqli_get('error') ? '' : 'unable to load connection.');

// clean up testing environment
mysqli\_dispose();
