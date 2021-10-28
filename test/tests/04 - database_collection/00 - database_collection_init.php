<?php

/**
 * Testing database_collection_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

 use function pirogue\database_collection_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

$GLOBALS['.pirogue-testing.database_collection.pattern'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']);

pirogue_test_execute("database_collection_init(): \$GLOBALS['._pirogue.database_collection.pattern']", function () {
    database_collection_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'website');
    return $GLOBALS['.pirogue-testing.database_collection.pattern'] == $GLOBALS['._pirogue.database_collection.pattern']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.pattern']";
});

pirogue_test_execute("database_collection_init(): \$GLOBALS['._pirogue.database_collection.default']", function () {
    database_collection_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'website');
    return 'website' == $GLOBALS['._pirogue.database_collection.default']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.default']]";
});

pirogue_test_execute("database_collection_init(): \$GLOBALS['._pirogue.database_collection.connections']", function () {
    database_collection_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'website');
    return empty($GLOBALS['._pirogue.database_collection.connections'])
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.connections']";
});

pirogue_test_execute("database_collection_init(): invalid default database", function () {
    try {
        database_collection_init($GLOBALS['.pirogue-testing.database_collection.pattern'], 'invalid');
        $database_connection = pirogue_database_collection_get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});
