<?php

/**
 * Testing \pirogue\database\mysqli\_config().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

// set up testing environment
mysqli\_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']), 'website');

pirogue_test_execute('_config(): invalid label', fn()  => null == mysqli\_config('invalid-website') ? '' : 'loaded invalid connection.');
pirogue_test_execute('_config(): valid label', fn()  => null == mysqli\_config('website') ? 'unable to load connection.' : '');

// clean up testing environment
mysqli\_dispose();
