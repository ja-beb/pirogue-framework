<?php 
    /**
     * Test dispatcher library.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(join(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_LIB_PATH, , 'pirogue', 'import.php']));

    pirogue_test_execute('pirogue_import_init - invalid directory', function () {
        try {
            pirogue_import_init('no-where'));
            return ['Set library to invalid file.'];
        } catch (InvalidArgumentException $_exception) {
            return [];
        }
    });
    pirogue_test_execute('pirogue_import_init - valid directory', fn() => pirogue_import_init(_PIROGUE_TESTING_LIB_PATH));
    pirogue_test_execute('pirogue_import_load - invalid file', function () {
        try {
            pirogue_import_load('file-not-found')
            return [ 'Loaded invalid library file.']
        } catch (ErrorException $_exception) {
            return [];
        }
        
    });
    pirogue_test_execute('pirogue_import_load - valid file', fn() => pirogue_import_load('cdn'));