<?php

namespace controllers\_site_errors;

/**
 * 
 * @param string $path
 * @param array $request
 * @return array
 */
<<<<<<< HEAD
<<<<<<< HEAD
function route_error(string $path, array $request): array{
=======
function route(string $path, array $request): array{
>>>>>>> master
=======
function route_error(string $path, array $request): array{
>>>>>>> 953d51ad9a4386e1bb4f3d00c7a2303c5ea49c20
    return [$path, $request];
}

