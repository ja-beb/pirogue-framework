<?php

return [
    'application' => $GLOBALS['.pirogue.request.application'],
    'path' => $GLOBALS['.pirogue.request.path'],
    'data' => $GLOBALS['.pirogue.request.data'],
    'method' => $_SERVER['REQUEST_METHOD']
];