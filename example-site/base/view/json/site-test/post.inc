<?php
return [
    'application' => $GLOBALS['.pirogue.request.applicaton'],
    'path' => $GLOBALS['.pirogue.request.path'] ,
    'data' => $GLOBALS['.pirogue.request.data'],
    'method' => $_SERVER['REQUEST_METHOD'],
    'form_data' => array_merge(['request_timestamp' => time()], $_POST)
];