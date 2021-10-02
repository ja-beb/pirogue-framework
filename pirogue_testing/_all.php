<?php

/**
 * Perform all testing of framework. Loads external test files from
 * the unit-test/ directory
 */
    
define('_PIROGUE_TESTING_LIB_PATH', '/project/pirogue');

$_unit_test_dir = implode(DIRECTORY_SEPARATOR, [__DIR__, 'unit-test']);

foreach ( scandir($_unit_test_dir) as $_file )
{
    if (str_ends_with($_file, '.php')) {
        echo 'file: ', $_file, "\n";
    }
}