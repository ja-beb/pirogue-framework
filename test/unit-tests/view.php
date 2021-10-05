<?php 
    /**
     * Test dispatcher library.
     * php version 8.0.0
     * 
     * @author Bourg, Sean <sean.bourg@gmail.com>
     */

    require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'view.php']));

    pirogue_test_execute('pirogue_view_init - invalid directory', function () {
        try {
            pirogue_view_init('no-where');
            return ['Set library to invalid file.'];
        } catch (InvalidArgumentException $_exception) {
            return [];
        }
    });
    pirogue_test_execute('pirogue_view_init - valid directory', fn() => pirogue_view_init(_PIROGUE_TESTING_PATH_VIEW));
    pirogue_test_execute('pirogue_import_load - invalid file', function () {
        $view = _pirogue_view_get_path('file-not-found');
        return '' == $view ? []: [ 'Loaded invalid library file.'] ;
    });
    
    pirogue_test_execute('pirogue_import_load - valid file', function () {
        $view = _pirogue_view_get_path('test');
        return '' == $view ? [ 'Loaded invalid library file.'] : [];
    });