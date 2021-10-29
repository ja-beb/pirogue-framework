<?php

/**
 * Testing controller_string_convert()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller_string_convert;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

pirogue_test_execute("controller_string_convert(): testing_index_get", function () {
    return controller_string_convert('testing_index-get') == 'testing_index_get' ? '' : 'invalid function name.';
});
