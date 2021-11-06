<?php

/**
 * Testing \pirogue\_database_mysqli_get().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_database_mysqli_init;
use function pirogue\_database_mysqli_dispose;
use function pirogue\_database_mysqli_get;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_mysqli.php']));

// set up testing environment
_database_mysqli_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

function _test_mysqli_get(string $label): ?\mysqli
{
    try {
        return _database_mysqli_get($label);
    } catch (Throwable) {
        return null;
    }
}

pirogue_test_execute('pirogue\_database_mysqli_get(): invalid label', fn()  => null == _test_mysqli_get('invalid-website') ? '' : 'loaded invalid connection.');
pirogue_test_execute('pirogue\_database_mysqli_get(): valid label', fn()  => null == _test_mysqli_get('website') ? 'unable to load connection "website".' : '');
pirogue_test_execute('pirogue\_database_mysqli_get(): valid label, invalid connection info', fn()  => null == _test_mysqli_get('error') ? '' : 'unable to load connection.');

// clean up testing environment
_database_mysqli_dispose();
