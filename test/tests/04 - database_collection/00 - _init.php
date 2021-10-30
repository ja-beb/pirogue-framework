<?php

/**
 * Testing _init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\database_collection\_init;
use function pirogue\database_collection\_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

$GLOBALS['.pirogue-testing.database_collection.pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']);

_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'website');
pirogue_test_execute("_init(): \$GLOBALS['._pirogue.database_collection.pattern']", function () {
    return $GLOBALS['.pirogue-testing.database_collection.pattern'] == $GLOBALS['._pirogue.database_collection.pattern']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.pattern']";
});
_dispose();

_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'website');
pirogue_test_execute("_init(): \$GLOBALS['._pirogue.database_collection.default']", function () {
    return 'website' == $GLOBALS['._pirogue.database_collection.default']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.default']]";
});
_dispose();

_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'website');
pirogue_test_execute("_init(): \$GLOBALS['._pirogue.database_collection.connections']", function () {
    return empty($GLOBALS['._pirogue.database_collection.connections'])
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.connections']";
});
_dispose();

_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'invalid');
pirogue_test_execute("_init(): invalid default database", function () {
    try {
        $database_connection = pirogue_database_collection_get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});
_dispose();
