<?php

/**
 * Org database functions.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace site_access;

use \UserAccessDeniedException;

/**
 * Fetch list of user's roles for given application
 *
 * @param resource $sqlsrv
 *            SQL Server resource.
 * @param int $user_id
 * @param string $application
 * @return array
 */
function site_access_fetch($sqlsrv, int $user_id, string $application = ''): array
{
    $_params = [
        '@user_id=?' => $user_id
    ];

    if (false == empty($application)) {
        $_params['@application_name=?'] = $application;
    }

    $_data = [];
    $_sql_statement = sqlsrv_query($sqlsrv, sprintf("execute site.user_roles_fetch %s", implode(',', array_keys($_params))), array_values($_params));
    if ($_sql_statement) {
        while ($_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC)) {
            if (false == array_key_exists($_sql_row['application_id'], $_data)) {
                $_data[$_sql_row['application_name']] = [];
            }
            array_push($_data[$_sql_row['application_name']], $_sql_row['role_name']);
        }
        sqlsrv_free_stmt($_sql_statement);
        if (false == empty($application)) {
            $_data = $_data[$application] ?? [];
        }
    }
    return $_data;
}

/**
 *
 * @param resource $sqlsrv
 * @param int $user_id
 * @param string $application
 * @param string $role
 * @throws UserAccessDeniedException
 */
function site_user_require_access($sqlsrv, int $user_id, string $application, string $role = '')
{
    $_roles = site_access_fetch($sqlsrv, $user_id, $application);
    if (empty($role)) {
        if (0 == count($_roles)) {
            throw new UserAccessDeniedException(false);
        }
    } elseif (false === array_search('user', $_roles)) {
        throw new UserAccessDeniedException(0 < count($_roles));
    }
}


