<?php

/**
 * Testing controller_import_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_import_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller_import.php']));

pirogue_test_execute("controller_import_init()", function () {
    $format = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'controllers', '%s.php']);
    controller_import_init($format);
    return $format == $GLOBALS['._pirogue.controller_import.controller_format']
        ? ''
        : 'invalid view directory.';
});
