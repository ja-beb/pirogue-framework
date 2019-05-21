<?php
/**
 * site database functions.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace site;

/**
 * helper function to perform a site.applications query.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function _applications_query($database_connection, string $query, array $params): array
{
    $_data = [];
    $_sql_statement = sqlsrv_query($database_connection, $query, $params);
    if ($_sql_statement) {
        while ($_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC)) {
            if (false == array_key_exists($_sql_row['application_id'], $_data)) {
                $_data[$_sql_row['application_id']] = [
                    'id' => $_sql_row['application_id'],
                    'name' => $_sql_row['application_name'],
                    'roles' => []
                ];
            }

            $_data[$_sql_row['application_id']]['roles'][$_sql_row['role_id']] = [
                'id' => $_sql_row['role_id'],
                'name' => $_sql_row['role_name']
            ];
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return array_values($_data);
}

/**
 * Lookup applications.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function applications_lookup($database_connection, string $filter, array $params): array
{
    return _applications_query($database_connection, sprintf('select * from site.application_roles where %s', $filter), $params);
}

/**
 * Fetch application and it's roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function applications_fetch($database_connection, int $id): ?array
{
    $_results = _applications_query($database_connection, 'select * from site.application_roles where application_id=?', [
        $id
    ]);
    return $_results[0] ?? null;
}

/**
 * Fetch application and it's roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function applications_list($database_connection): array
{
    return _applications_query($database_connection, 'select * from site.application_roles', []);
}


/**
 * Execute a query on the org schema tables and return the results as an array.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $query
 * @param array $params
 * @return array
 */
function _users_query($database_connection, string $query, array $params = []): array
{
    $_sql_statement = sqlsrv_query($database_connection, $query, $params);
    $_data = [];
    if ($_sql_statement) {
        while ($_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC)) {
            if ( false == array_key_exists($_sql_row['id'], $_data)){
                $_data[$_sql_row['id']] = [
                    'id' => $_sql_row['id'],
                    'email' => $_sql_row['email'],
                    'status_code' => $_sql_row['status_code'],
                    'applications' => []
                ];
            }
            
            if ( false == array_key_exists($_sql_row['application_id'], $_data[$_sql_row['id']]['applications']) ){
                $_data[$_sql_row['id']]['applications'][$_sql_row['application_id']] = [
                    'id' => $_sql_row['application_id'],
                    'name' => $_sql_row['application_name'],
                    'roles' => []
                ];
            }
            
            $_data[$_sql_row['id']]['applications'][$_sql_row['application_id']]['roles'] = [
                'id' => $_sql_row['role_id'],
                'name' => $_sql_row['role_name']
            ];
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return array_values($_data);
}

/**
 * List site users and their assigned roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function users_list($database_connection): array
{
    return _users_query($database_connection, 'select * from site.user_details', []);
}

/**
 * Fetch site user and their assigned roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function users_fetch($database_connection, int $id): ?array
{
    $_results = _users_query($database_connection, 'select * from site.user_details where id=?', [$id]);    
    return $_results[0] ?? null;
}

/**
 * Lookup site users and their assigned roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function users_lookup($database_connection, string $filter, array $params): array
{
    return _users_query($database_connection, sprintf('select * from site.user_details where %s', $filter), $params);
}



/**
 * helper function to perform a site.applications query for roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function _application_roles_query($database_connection, string $query, array $params): array
{
    $_data = [];
    $_sql_statement = sqlsrv_query($database_connection, $query, $params);
    if ($_sql_statement) {
        while ($_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC)) {
            $_data[$_sql_row['role_id']] = $_sql_row;
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return array_values($_data);
}

/**
 * Lookup application roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function applications_roles_list($database_connection): array
{
    return _application_roles_query($database_connection, 'select * from site.application_roles ', []);
}



/**
 * Lookup application roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function applications_roles_fetch($database_connection, int $id): ?array
{
    $_results = _application_roles_query($database_connection, 'select * from site.application_roles where role_id=?', [$id]);
    return $_results[0] ?? null;
}


/**
 * Lookup application roles.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function applications_roles_lookup($database_connection, string $filter, array $params): array
{
    return _application_roles_query($database_connection, sprintf('select * from site.application_roles where %s', $filter), $params);
}


