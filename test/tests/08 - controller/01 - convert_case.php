<?php

/**
 * Testing convert_case()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\controller\convert_case;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

pirogue_test_execute("convert_case(): testing_index_get", function () {
    return convert_case('testing_index-get') == 'testing_index_get' ? '' : 'invalid function name.';
});
