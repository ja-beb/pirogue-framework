<?php

/**
 * Testing pirogue\_database_mysqli_init() and pirogue\_database_mysqli_dispose().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_database_mysqli_init;
use function pirogue\_database_mysqli_dispose;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'database_mysqli.php']));

$GLOBALS['._pirogue-testing.database_mysqli.path_format'] = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config', 'mysqli-%s.ini']);

_database_mysqli_init($GLOBALS['._pirogue-testing.database_mysqli.path_format'], 'website');
pirogue_test_execute('pirogue\_database_mysqli_init()', function () {
    return $GLOBALS['._pirogue-testing.database_mysqli.path_format'] == $GLOBALS['._pirogue.database_mysqli.path_format']
        ? ''
        : 'invalid value for path format';
});

pirogue_test_execute('pirogue\_database_mysqli_init()', function () {
    return 'website' == $GLOBALS['._pirogue.database_mysqli.default']
        ? ''
        : 'invalid value for default conneection';
});

pirogue_test_execute('pirogue\_database_mysqli_init()', function () {
    return empty($GLOBALS['._pirogue.database_mysqli.connections'])
        ? ''
        : 'invalid value for collections';
});
_database_mysqli_dispose();

_database_mysqli_init($GLOBALS['._pirogue-testing.database_mysqli.path_format'], 'invalid');
pirogue_test_execute('pirogue\_database_mysqli_init()', function () {
    try {
        $database_connection = mysqli\get();
        return 'invalid database connnection was returned.';
    } catch (Throwable) {
        return '';
    }
});

_database_mysqli_dispose();
pirogue_test_execute('pirogue\_database_mysqli_dispose()', fn () => array_key_exists('._pirogue.database_mysqli.path_format', $GLOBALS) ? 'did not unset "._pirogue.database_mysqli.path_format"' : '');
pirogue_test_execute('pirogue\_database_mysqli_dispose()', fn () => array_key_exists('._pirogue.database_mysqli.default', $GLOBALS) ? 'did not unset "._pirogue.database_mysqli.default"' : '');
pirogue_test_execute('pirogue\_database_mysqli_dispose()', fn () => array_key_exists('._pirogue.database_mysqli.connections', $GLOBALS) ? 'did not unset "._pirogue.database_mysqli.connections"' : '');
