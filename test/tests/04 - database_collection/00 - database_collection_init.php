<?php

/**
 * Testing database_collection_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

 use function pirogue\database_collection_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

$GLOBALS['.pirogue-testing.database_collection.config_path'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config']);

pirogue_test_execute('database_collection_init(): invalid config directory', function () {
    try {
        database_collection_init(
            implode(DIRECTORY_SEPARATOR, [$GLOBALS['.pirogue-testing.database_collection.config_path'], 'config-invalid']),
            'website'
        );
        return 'Invalid database config directory accepted.';
    } catch (InvalidArgumentException) {
        return '';
    }
});

pirogue_test_execute(
    'database_collection_init(): valid config directory',
    fn() => database_collection_init($GLOBALS['.pirogue-testing.database_collection.config_path'], 'website')
);

pirogue_test_execute("database_collection_init(): \$GLOBALS['._pirogue.database_collection.config_path']", function () {
    database_collection_init($GLOBALS['.pirogue-testing.database_collection.config_path'], 'website');
    return $GLOBALS['.pirogue-testing.database_collection.config_path'] == $GLOBALS['._pirogue.database_collection.config_path']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.config_path']";
});

pirogue_test_execute("database_collection_init(): \$GLOBALS['._pirogue.database_collection.default']", function () {
    database_collection_init($GLOBALS['.pirogue-testing.database_collection.config_path'], 'website');
    return 'website' == $GLOBALS['._pirogue.database_collection.default']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.default']]";
});

pirogue_test_execute("database_collection_init(): \$GLOBALS['._pirogue.database_collection.connections']", function () {
    database_collection_init($GLOBALS['.pirogue-testing.database_collection.config_path'], 'website');
    return empty($GLOBALS['._pirogue.database_collection.connections'])
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.connections']";
});

pirogue_test_execute("database_collection_init(): invalid default database", function () {
    try {
        database_collection_init($GLOBALS['.pirogue-testing.database_collection.config_path'], 'invalid');
        $database_connection = pirogue_database_collection_get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});
