<?php

/**
 * Org database functions.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace site_access;

/**
 * Execute SQL query and return results.
 * @param sqlsrv resource $database_connection
 * @param string $query
 * @param array $params
 * @return array
 */
function _role_fetch($database_connection, string $query, array $params): array
{
    $_data = [];
    $_sql_statement = sqlsrv_query($database_connection, $query, $params);
    if ($_sql_statement) {
        while ($_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC)) {
            array_push($_data, $_sql_row);
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return $_data;
}

/**
 * Check if user has access to a given role.
 * @param sqlsrv resource $sqlsrv
 * @param int $user_id
 * @param string $application
 * @param string $role
 * @return bool
 */
function role_has_access($sqlsrv, int $user_id, string $application, string $role): bool
{
    $_data = _role_fetch($sqlsrv, 'EXECUTE site.user_roles_fetch @user_id=?, @application_name=?, @role_name=?', [
        $user_id,
        $application,
        $role
    ]);
    return (0 < count($_data));
}

/**
 * Fetch list of user's roles for given application
 * @param sqlsrv resource $sqlsrv
 * @param int $user_id
 * @param string $application
 * @return array
 */
function application_roles_fetch($sqlsrv, int $user_id, string $application): array
{
    return _role_fetch($sqlsrv, 'EXECUTE site.user_roles_fetch @user_id=?, @application_name=?', [
        $user_id,
        $application
    ]);
}

/**
 * Fetch list of user's applications
 * @param sqlsrv resource $sqlsrv
 * @param int $user_id
 * @return array
 */
function application_list($sqlsrv, int $user_id): array
{
    return _role_fetch($sqlsrv, 'EXECUTE site.user_roles_fetch @user_id=?', [
        $user_id
    ]);
}