<?php

/**
 * Testing pirogue_view_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'view.php']));

pirogue_test_execute('pirogue_view_init(): invalid directory', function () {
    try {
        pirogue_view_init('/invalid/path');
        return ['initialized to invalid directory.'];
    } catch (InvalidArgumentException) {
        return [];
    }
});

pirogue_test_execute(
    'pirogue_view_init(): valid directory',
    fn () => pirogue_view_init(_PIROGUE_TESTING_PATH_VIEW)
);

pirogue_test_execute("pirogue_view_init(): \$GLOBALS['._pirogue.view.path']", function () {
    pirogue_view_init(_PIROGUE_TESTING_PATH_VIEW);
    return _PIROGUE_TESTING_PATH_VIEW == $GLOBALS['._pirogue.view.path']
        ? []
        : ['invalid view directory.'];
});

pirogue_test_execute("pirogue_view_init(): \$GLOBALS['._pirogue.view.extension']", function () {
    pirogue_view_init(_PIROGUE_TESTING_PATH_VIEW, 'phtml');
    return 'phtml' == $GLOBALS['._pirogue.view.extension']
        ? []
        : ['invalid extension.'];
});
