<?php

/**
 * Testing pirogue\database\mysqli\_init() and _dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use pirogue\database\mysqli;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database', 'mysqli.php']));

$GLOBALS['.pirogue-testing.database.mysqli.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']);

mysqli\_init($GLOBALS['.pirogue-testing.database.mysqli.path_format'], 'website');
pirogue_test_execute('_init()', function () {
    return $GLOBALS['.pirogue-testing.database.mysqli.path_format'] == $GLOBALS['._pirogue.database.mysqli.path_format']
        ? ''
        : 'invalid value for path format';
});

pirogue_test_execute('_init()', function () {
    return 'website' == $GLOBALS['._pirogue.database.mysqli.default']
        ? ''
        : 'invalid value for default conneection';
});

pirogue_test_execute('_init()', function () {
    return empty($GLOBALS['._pirogue.database.mysqli.connections'])
        ? ''
        : 'invalid value for collections';
});
mysqli\_dispose();

mysqli\_init($GLOBALS['.pirogue-testing.database.mysqli.path_format'], 'invalid');
pirogue_test_execute('_init()', function () {
    try {
        $database_connection = mysqli\get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});

mysqli\_dispose();
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database.mysqli.path_format', $GLOBALS) ? 'did not unset "._pirogue.database.mysqli.path_format"' : '');
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database.mysqli.default', $GLOBALS) ? 'did not unset "._pirogue.database.mysqli.default"' : '');
pirogue_test_execute('_dispose()', fn () => array_key_exists('._pirogue.database.mysqli.connections', $GLOBALS) ? 'did not unset "._pirogue.database.mysqli.connections"' : '');
