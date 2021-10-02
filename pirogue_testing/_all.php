<?php

/**
 * Perform all testing of framework. Loads external test files from
 * the unit-test/ directory
 */
    
define('_PIROGUE_TESTING_LIB_PATH', realdir('../pirogue'));

 for ( dir('./unit-testing') as $_file)
 {
     echo $_file;
 }