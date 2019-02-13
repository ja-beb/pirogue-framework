<?php

namespace controllers\_SiteErrors;

/**
 * 
 * @param string $path
 * @param array $request
 * @return array
 */
function get_404(string $path, array $request): array{
    return _error_404($path, $request);
}

function post_404(string $path, array $request): array{
    return _error_404($path, $request);
}

function get_403(string $path, array $request): array{
    return _error_403($path, $request);
}

function post_403(string $path, array $request): array{
    return _error_403($path, $request);
}


function get_500(string $path, array $request): array{
    return _error_500($path, $request);
}

function post_500(string $path, array $request): array{
    return _error_500($path, $request);
}


function _error_403(string $path, array $request): array{
    return ['path' => $path, 'data' => $request ];
}


function _error_404(string $path, array $request): array{
    return ['path' => $path, 'data' => $request ];
}


function _error_500(string $path, array $request): array{
    return ['path' => $path, 'data' => $request ];
}
