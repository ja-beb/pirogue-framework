<?php

/**
 * Testing _init() and _dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database_collection;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_collection.php']));

$GLOBALS['.pirogue-testing.database_collection.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']);

database_collection\_init($GLOBALS['.pirogue-testing.database_collection.path_format'], 'website');
pirogue_test_execute('_init()', function () {
    return $GLOBALS['.pirogue-testing.database_collection.path_format'] == $GLOBALS['._pirogue.database_collection.path_format']
        ? ''
        : 'invalid value for path format';
});

pirogue_test_execute('_init()', function () {
    return 'website' == $GLOBALS['._pirogue.database_collection.default']
        ? ''
        : 'invalid value for default conneection';
});

pirogue_test_execute('_init()', function () {
    return empty($GLOBALS['._pirogue.database_collection.connections'])
        ? ''
        : 'invalid value for collections';
});
database_collection\_dispose();

database_collection\_init($GLOBALS['.pirogue-testing.database_collection.path_format'], 'invalid');
pirogue_test_execute('_init()', function () {
    try {
        $database_connection = pirogue_database_collection_get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});

database_collection\_dispose();
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database_collection.path_format', $GLOBALS) ? 'did not unset "._pirogue.database_collection.path_format"' : '');
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database_collection.default', $GLOBALS) ? 'did not unset "._pirogue.database_collection.default"' : '');
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database_collection.connections', $GLOBALS) ? 'did not unset "._pirogue.database_collection.connections"' : '');
