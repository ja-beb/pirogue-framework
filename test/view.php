<?php 
    /**
     * Test dispatcher library.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(join(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, 'dispatcher.php']));

    // test pirogue_view_init
    # pirogue_test_run('dispatcher-00', fn() => cdn_test([],3));

    // test _pirogue_view_get_path
