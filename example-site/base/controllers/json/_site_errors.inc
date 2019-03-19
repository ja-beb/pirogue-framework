<?php

namespace controllers\_site_errors;

/**
 * 
 * @param string $path
 * @param array $request
 * @return array
 */
function route(string $path, array $request): array{
    http_response_code($path); 
    return [$path, $request, $request[0] ?? ''];
}

