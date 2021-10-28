<?php

/**
 * Testing dispatcher_path_convert_to_array()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\dispatcher_path_convert_to_array;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

pirogue_test_execute('dispatcher_path_convert_to_array()', function () {
    $data = [
        'output' => ['first', 'second', 'third'],
        'input' => 'first/_second/__third',
    ];
    $results = dispatcher_path_convert_to_array($data['input']);

    for ($i = 0; $i < count($results); $i++) {
        if ($results[$i] != $data['output'][$i]) {
            return sprintf(
                'did not process path element correctly: expecting "%s" but recieved "%s"',
                $data['output'][$i],
                $results[$i]
            );
        }
    }

    return '';
});
