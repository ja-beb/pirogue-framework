<?php

/**
 * Perform all testing of framework. Loads external test files from
 * the unit-test/ directory
 */
    
// dd error handler: all warnings and errors are be hgandles
set_error_handler(fn ($severity, $message, $file, $line) => throw new ErrorException($message, $severity, $severity, $file, $line));
ini_set("display_errors", 1);
error_reporting(E_ALL);


// define base folder.
define('_PIROGUE_TESTING_TEST_PATH', __DIR__);
define('_PIROGUE_TESTING_PATH', dirname(_PIROGUE_TESTING_TEST_PATH));
define('_PIROGUE_TESTING_LIB_PATH', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'pirogue']));

$GLOBALS['._pirogue_test.count_test'] = 0;
$GLOBALS['._pirogue_test.count_errors'] = 0;

/**
 * 
 */
function _pirogue_test_log(string $label, string $msg): void {
    echo "[{$label}] {$msg}\n";
}

/**
 * 
 */
function pirogue_test_run(string $label, $callable): void{
    $GLOBALS['._pirogue_test.count_test']++;
    try{
        $_errors = $callable() ?? [];
        if (!empty($_errors)){
            foreach( $_errors as $_message ){
                $GLOBALS['._pirogue_test.count_errors']++;
                _pirogue_test_log($label, $_message);                
            }
        }
    } catch (Throwable $e) {
        $GLOBALS['._pirogue_test.count_errors']++;            
        _pirogue_test_log($label, sprintf('Exception encountered: %s', $e->getMessage()));
    }
}

/**
 * 
 */
function _pirogue_test_load($dir): void{
    foreach ( scandir($dir) as $_file )
    {
        if (!str_starts_with($_file, '_') && str_ends_with($_file, '.php')) {
            try{
                echo '[load] ', $_file, "\n";
                include(implode(DIRECTORY_SEPARATOR, [$dir, $_file]));
            } catch (Throwable $e) {
                echo 'File level error encoungered: ', $e->getMessage();
            }
        }
    }
}


_pirogue_test_load(__DIR__);
echo "[results] {$GLOBALS['._pirogue_test.count_test']} test(s), {$GLOBALS['._pirogue_test.count_errors']} error(s).\n";
