<?php

/**
 * Testing _pirogue_database_collection_destruct().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include'f, 'pirogue', 'database_collection.php']));

pirogue_test_execute('_pirogue_database_collection_destruct()', function () {
    _pirogue_database_collection_destruct();
    return empty($GLOBALS['._pirogue.database_collection.connections']) ? '' : 'registered connections exist.';
});
