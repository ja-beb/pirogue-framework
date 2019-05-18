<?php
namespace controllers\json\user\current;

/**
 * 
 * @param string $path
 * @param array $request
 * @return array
 */
function get_status(string $path, array $request): array{
    return ['status' => 'awakish' ];
}
