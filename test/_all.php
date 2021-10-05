<?php

/**
 * Perform all testing of framework. Loads external test files from
 * the unit-test/ directory
 */
    
// PHP error handler: all warnings and errors are reported and handled.
set_error_handler(fn ($severity, $message, $file, $line) => throw new ErrorException($message, $severity, $severity, $file, $line));
ini_set("display_errors", 1);
error_reporting(E_ALL | E_STRICT);

// define base folder.
define('_PIROGUE_TESTING_PATH', dirname(__DIR__, 1));
define('_PIROGUE_TESTING_TEST_PATH', __DIR__);
define('_PIROGUE_TESTING_LIB_PATH', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include']));
define('_PIROGUE_TESTING_VIEW_PATH', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view']));

// Global variables for test counts
$GLOBALS['._pirogue_test.count_test'] = 0;
$GLOBALS['._pirogue_test.count_errors'] = 0;

/**
 * Log error message.
 * 
 * @param string $label the test's label.
 * @param array $errors list of errors encoutered. if successful the array is empty.
 */
function _pirogue_test_log(string $label, array $errors): void 
{
    if ( empty($errors) ) {
        echo "[{$label}] SUCCESS\n";
    }else {
        $GLOBALS['._pirogue_test.count_errors']++;
        echo "[{$label}] FAILED.\n";
        foreach( $errors as $_message ){        
            echo "\t{$_message}\n";
        }    
    }
}

/**
 * Execute unit test.
 * 
 * @param string $label the test's label.
 * @param callable $callable function to perform test, returns an array of error messages or empty if no
 * errors were encountered.
 */
function pirogue_test_execute(string $label, $callable): void
{
    try{
        $GLOBALS['._pirogue_test.count_test']++;    
        _pirogue_test_log($label, $callable() ?? []);
    } catch (Throwable $e) {
        _pirogue_test_log($label, [$e->getMessage()]);
    }
}

/**
 * Load test file.
 * 
 * @param string $path directory containing test file.
 * @param string $filename name of test file.
 */
function _pirogue_test_load(string $path, string $filename): void {
    try{
        require(implode(DIRECTORY_SEPARATOR, [__DIR__, $filename]));
    } catch (Throwable $e) {
        _pirogue_test_log("_pirogue_test_load - load {$filename}", [$e->getMessage()]);
    }
}


foreach ( scandir(__DIR__) as $_filename )
{
    if ( preg_match('/^[^_](.*)\.php$/', $_filename) ) {
        _pirogue_test_load(__DIR__, $_filename);
    }
}
echo "[results] {$GLOBALS['._pirogue_test.count_test']} test(s), {$GLOBALS['._pirogue_test.count_errors']} error(s).\n";
