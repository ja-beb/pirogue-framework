<?php

/**
 * Testing _pirogue_database_collection_get_config_file().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'database_collection.php']));

pirogue_test_execute('_pirogue_database_collection_get_config_file(): invalid file', function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    return '' == _pirogue_database_collection_get_config_file('invalid-connection')
        ? ''
        : 'returned invalid config file.';
});

pirogue_test_execute('_pirogue_database_collection_get_config_file(): valid file', function () {
    pirogue_database_collection_init(_PIROGUE_TESTING_PATH_CONFIG, 'website');
    $file = sprintf('%s/mysqli-website.ini', _PIROGUE_TESTING_PATH_CONFIG);
    $file_returned = _pirogue_database_collection_get_config_file('website');
    return $file == $file_returned ? '' : "invalid config file returned '{$file_returned}'";
});
