<?php
return [
    'path' => $GLOBALS['.pirogue.view.path'],
    'data' => $GLOBALS['.pirogue.view.data'],
    'method' => $_SERVER['REQUEST_METHOD'],
    'form_data' => array_merge(['request_timestamp' => time()], $_POST)
];