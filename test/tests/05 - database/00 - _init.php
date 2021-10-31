<?php

/**
 * Testing pirogue\database\_init() and _dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database.php']));

$GLOBALS['.pirogue-testing.database.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']);

database\_init($GLOBALS['.pirogue-testing.database.path_format'], 'website');
pirogue_test_execute('_init()', function () {
    return $GLOBALS['.pirogue-testing.database.path_format'] == $GLOBALS['._pirogue.database.path_format']
        ? ''
        : 'invalid value for path format';
});

pirogue_test_execute('_init()', function () {
    return 'website' == $GLOBALS['._pirogue.database.default']
        ? ''
        : 'invalid value for default conneection';
});

pirogue_test_execute('_init()', function () {
    return empty($GLOBALS['._pirogue.database.connections'])
        ? ''
        : 'invalid value for collections';
});
database\_dispose();

database\_init($GLOBALS['.pirogue-testing.database.path_format'], 'invalid');
pirogue_test_execute('_init()', function () {
    try {
        $database_connection = pirogue_database_get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});

database\_dispose();
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database.path_format', $GLOBALS) ? 'did not unset "._pirogue.database.path_format"' : '');
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database.default', $GLOBALS) ? 'did not unset "._pirogue.database.default"' : '');
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database.connections', $GLOBALS) ? 'did not unset "._pirogue.database.connections"' : '');
