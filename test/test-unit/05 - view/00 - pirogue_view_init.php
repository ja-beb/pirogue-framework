<?php

/**
 * Testing pirogue_view_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'view.php']));

pirogue_test_execute("pirogue_view_init(): \$GLOBALS['._pirogue.view.path']", function () {
    $format = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']);
    pirogue_view_init($format);
    return $format == $GLOBALS['._pirogue.view.format']
        ? ''
        : 'invalid view directory.';
});
