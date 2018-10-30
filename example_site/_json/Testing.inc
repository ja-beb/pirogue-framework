<?php
namespace Testing;

/**
 *
 * @param string $path
 * @param array $request
 * @return array
 */
function get_user(string $path, array $request): array
{
    return [
        'id' => 1,
        'username' => 'test',
        'displayName' => 'Test user'
    ];
}

/**
 *
 * @param string $path
 * @param array $request
 * @param array $form_data
 */
function post_user(string $path, array $request, array $form_data)
{
    return get_user($path, $request);
}

/**
 *
 * @param string $path
 * @param array $request
 * @return array
 */
function get_notices(string $path, array $request): array
{
    import('sprout/database_collection');

    $list = [];
    $sql_connection = \sprout\database_collection_open('website');
    $sql_results = sqlsrv_query($sql_connection, sprintf('SELECT Body, DateCreated FROM Site.Messages WHERE SiteUserId=%d ORDER BY DateCreated', 1));
    while ($sql_data = sqlsrv_fetch_array($sql_results, SQLSRV_FETCH_ASSOC)) {
        array_push($list, $sql_data);
    }
    sqlsrv_free_stmt($sql_results);
    return $list;
}
