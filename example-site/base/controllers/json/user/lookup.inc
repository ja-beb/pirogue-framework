<?php
namespace controllers\user\lookup;

/**
 * 
 * @param string $path
 * @param array $request
 * @return array
 */
function get_status(string $path, array $request): array{
    return ['status' => 'awake' ];
}

