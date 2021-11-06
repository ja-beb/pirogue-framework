<?php

/**
 * Testing pirogue\database_mysqli_close_all().
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_database_mysqli_init;
use function pirogue\_database_mysqli_dispose;
use function pirogue\database_mysqli_close_all;
use function pirogue\database_mysqli_get;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_mysqli.php']));

// set up testing environment
_database_mysqli_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

pirogue_test_execute('pirogue\database_mysqli_close_all(): empty', fn () => database_mysqli_close_all());
pirogue_test_execute('pirogue\database_mysqli_close_all(): not empty', function () {
    $databaase = database_mysqli_get('website');
    database_mysqli_close_all();
    return empty($GLOBALS['._pirogue.database.mysqli.connections']) ? '' : 'connections not closed.';
});
pirogue_test_execute('close_all(): empty', fn () => database_mysqli_close_all());

_database_mysqli_dispose();
