<?php

/**
 * Testing _dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

 use function pirogue\database_collection\_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

pirogue_test_execute('_dispose()', function () {
    _dispose();
    return empty($GLOBALS['._pirogue.database_collection.connections']) ? '' : 'registered connections exist.';
});
