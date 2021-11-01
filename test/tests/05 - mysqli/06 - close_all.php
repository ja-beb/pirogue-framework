<?php

/**
 * Testing pirogue\database\mysqli\close_all().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

// set up testing environment
mysqli\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

pirogue_test_execute('close_all(): empty', fn () => mysqli\close_all());
pirogue_test_execute('close_all(): not empty', function () {
    $databaase = mysqli\get('website');
    mysqli\close_all();
    return empty($GLOBALS['._pirogue.database.mysqli.connections']) ? '' : 'connections not closed.';
});
pirogue_test_execute('close_all(): empty', fn () => mysqli\close_all());

mysqli\_dispose();
