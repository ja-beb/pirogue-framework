<?php

/**
 * Testing view_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\view_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'view.php']));

pirogue_test_execute("view_init(): \$GLOBALS['._pirogue.view.path']", function () {
    $format = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']);
    view_init($format);
    return $format == $GLOBALS['._pirogue.view.format']
        ? ''
        : 'invalid view directory.';
});
