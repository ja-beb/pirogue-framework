<?php

/**
 * Testing pirogue\dispatcher_request_path_parse()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\dispatcher_request_path_parse;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'dispatcher.php']));

pirogue_test_execute('pirogue\dispatcher_request_path_parse()', function () {
    $data = [
        'output' => ['first', 'second', 'third'],
        'input' => 'first/_second/__third',
    ];
    $results = dispatcher_request_path_parse($data['input']);

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
