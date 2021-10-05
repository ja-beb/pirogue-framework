<?php 
    /**
     * Test dispatcher library.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(join(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, 'pirogue', 'dispatcher.php']));

    pirogue_test_execute('pirogue_view_init', function() {
    });

    _pirogue_view_get_path('_pirogue_view_get_path', function() {
    });

    _pirogue_view_get_path('_pirogue_view_get_path', function() {
    });


    pirogue_test_execute('pirogue_view_init - invalid directory', function () {
        try {
            pirogue_view_init('no-where'));
            return ['Set library to invalid file.'];
        } catch (InvalidArgumentException $_exception) {
            return [];
        }
    });
    pirogue_test_execute('pirogue_view_init - valid directory', fn() => pirogue_view_init(_PIROGUE_TESTING_VIEW_PATH));
    pirogue_test_execute('pirogue_import_load - invalid file', function () {
        try {
            pirogue_import_load('file-not-found')
            return [ 'Loaded invalid library file.']
        } catch (ErrorException $_exception) {
            return [];
        }
        
    });
    pirogue_test_execute('pirogue_import_load - valid file', fn() => pirogue_import_load('cdn'));