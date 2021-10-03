<?php 
    /**
     * Test dispatcher library.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(join(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, 'database-collection.inc']));

    // test pirogue_database_collection_init - invalid directory
    pirogue_test_run('database-collection-00', function(){
        try{
        pirogue_database_collection_init(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, 'config-invalid']));
        if ( null != pirogue_database_collection_get() ) {

        } else {

        }
    });


    // test pirogue_database_collection_init - valid directory


    // test pirogue_database_collection_get

    
    // test pirogue_database_collection_destruct
