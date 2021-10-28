<?php

/**
 * testing function for controller - returns input.
 * 
 * @param array $path path for this request.
 * @param array $data data for this request.
 * @return string path parsed.
 */
function testing_index_get(array $path, array $data): string {
    return implode('/', $path);
}