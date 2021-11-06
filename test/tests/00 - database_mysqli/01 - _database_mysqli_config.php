<?php

/**
 * Testing \pirogue\_database_mysqli_config().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_database_mysqli_init;
use function pirogue\_database_mysqli_dispose;
use function pirogue\_database_mysqli_config;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_mysqli.php']));

// set up testing environment
_database_mysqli_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');
pirogue_test_execute('pirogue\_database_mysqli_config(): invalid label', fn()  => null == _database_mysqli_config('invalid-website') ? '' : 'loaded invalid connection.');
pirogue_test_execute('pirogue\_database_mysqli_config(): valid label', fn()  => null == _database_mysqli_config('website') ? 'unable to load connection.' : '');

_database_mysqli_dispose();
