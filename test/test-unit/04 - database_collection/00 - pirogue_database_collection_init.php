<?php

/**
 * Testing pirogue_database_collection_init().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

define('_PIROGUE_TESTING_PATH_CONFIG', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config']));

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

pirogue_test_execute('pirogue_database_collection_init(): invalid config directory', function () {
    try {
        pirogue_database_collection_init(
            implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_CONFIG, 'config-invalid']),
            'website'
        );
        return 'Invalid database config directory accepted.';
    } catch (InvalidArgumentException) {
        return '';
    }
});

pirogue_test_execute(
    'pirogue_database_collection_init(): valid config directory',
    fn() => pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website')
);

pirogue_test_execute("pirogue_database_collection_init(): \$GLOBALS['._pirogue.database_collection.config_path']", function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    return _PIROGUE_TESTING_PATH_CONFIG == $GLOBALS['._pirogue.database_collection.config_path']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.config_path']";
});

pirogue_test_execute("pirogue_database_collection_init(): \$GLOBALS['._pirogue.database_collection.default']", function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    return 'website' == $GLOBALS['._pirogue.database_collection.default']
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.default']]";
});

pirogue_test_execute("pirogue_database_collection_init(): \$GLOBALS['._pirogue.database_collection.connections']", function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    return empty($GLOBALS['._pirogue.database_collection.connections'])
        ? ''
        : "invalid value for \$GLOBALS['._pirogue.database_collection.connections']";
});
