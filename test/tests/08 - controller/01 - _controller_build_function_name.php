<?php

/**
 * Testing _controller_build_function_name()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_controller_build_function_name;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'controller.php']));

pirogue_test_execute("_controller_build_function_name(): testing_index_get", function () {
    $parts = ['testing', 'index', 'GET'];
    return _controller_build_function_name($parts) == 'testing_index_get' ? '' : 'invalid function name.';
});

pirogue_test_execute("_controller_build_function_name(): remove kebab case", function () {
    $parts = ['testing', 'update-info', 'GET'];
    return _controller_build_function_name($parts) == 'testing_update_info_get' ? '' : 'invalid function name: kebab case.';
});
