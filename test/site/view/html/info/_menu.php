<?php 


return [
    [
        'title' => 'View php info output.',
        'label' => 'PHP Info',
        'path' => 'php.html',
        'request' => []
    ],
    [
        'title' => 'View session data.',
        'label' => 'Session Data',
        'path' => 'session.html',
        'request' => []
    ],
    [
        'title' => 'View framework data.',
        'label' => 'Pirogue Framework Data',
        'path' => 'pirogue-vars.html',
        'request' => []
    ],
    [
        'title' => 'View dispatcher data.',
        'label' => 'Dispatcher Data',
        'path' => 'dispatcher-vars/page/options.html',
        'request' => [
            'test1' => 'true',
            'test2' => 'false'
        ]
    ]
];