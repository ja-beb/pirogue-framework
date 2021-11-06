<?php

/**
 * Testing pirogue\_dispatcher_route_convert_case()
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\_dispatcher_route_convert_case;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

pirogue_test_execute('pirogue\_dispatcher_route_convert_case()', function () {
    $return_value = _dispatcher_route_convert_case('test-controller\test-action');
    return 'test_controller\test_action' == $return_value ? '' : sprintf('returned invalid value "%s".', $return_value);
});
