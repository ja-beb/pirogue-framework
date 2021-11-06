<?php

/**
 * initialize controller.
 *
 * @param string $name controller name.
 * @return void
 */

namespace edit;

/**
 * initialize this library.
 *
 * @internal
 * @param string $name
 * @return void
 */
function _init(string $name): void{}

/**
 * finalize this library.
 * 
 * @internal
 * @return void
 */
function _dispose(): void{}

/**
 * validate access.
 *
 * @param integer|null $user_id
 * @return bool returns false if user id is null.
 */
function has_access(?int $user_id): bool{
    return null != $user_id;
}

/**
 * index get action.
 * 
 * @param array $path
 * @param array $data
 * @return array
 */
function index_get(array $path, array $data): array {
    return ['file' => __FILE__, 'function' => __FUNCTION__, 'path' => $path, 'data' => $data];
}

/**
 * index post action.
 * 
 * @param array $path
 * @param array $data
 * @param array $form_data
 * @return array
 */
function index_post(array $path, array $data, array $form_data): array {
    return ['file' => __FILE__, 'function' => __FUNCTION__, 'path' => $path, 'data' => $data, 'form_data' => $form_data];
}

/**
 * fallback get action.
 * 
 * @param array $path
 * @param array $data
 * @return array
 */
function fallback_get(array $path, array $data): array {
    return ['file' => __FILE__, 'function' => __FUNCTION__, 'path' => $path, 'data' => $data];
}