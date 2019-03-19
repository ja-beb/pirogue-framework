<?php
namespace site_users;

define('_SITE_USER_STATUS_DISABLED', 0);
define('_SITE_USER_STATUS_ACTIVE', 1);

/**
 *
 * @param resource $sql_server
 *            SQL Server Connection
 * @param int $id
 * @return array
 */
function fetch($sql_server, int $id): array
{
    return _fetch($sql_server, 'id=?', [
        $id
    ]);
}

/**
 *
 * @param resource $sql_server
 *            SQL Server Connection
 * @param string $email
 * @return array
 */
function lookup($sql_server, string $email): array
{
    return _fetch($sql_server, 'email=?', [
        $email
    ]);
}

function password_verify($sql_server, int $id, string $password): array
{
    return _fetch($sql_server, 'id=? AND [password]=site.password_encrypt(?)', [
        $id,
        $password
    ]);
}

function _fetch($sql_server, string $filter, array $params): array
{
    $_statement = sqlsrv_query($sql_server, sprintf('SELECT id, email, name, status FROM site.users WHERE %s', $filter), $params);
    $_data = sqlsrv_fetch_array($_statement, SQLSRV_FETCH_ASSOC);
    sqlsrv_free_stmt($_statement);
    return $_data ?? [];
}

function password_update($sql_server, int $id, string $password): array
{
    // Verify email address before updating!
    $_statement = sqlsrv_query($sql_server, 'UPDATE site.users SET [password]=site.password_encrypt(?) WHERE Id=?', [
        $password,
        $id
    ]);
    $_update_status = (0 < sqlsrv_rows_affected($_statement));
    sqlsrv_free_stmt($_statement);
    return $_update_status;
}

function name_update($sql_server, int $id, string $name): array
{
    $_statement = sqlsrv_query($sql_server, 'UPDATE site.users SET [name]=? WHERE Id=?', [
        $name,
        $id
    ]);
    $_update_status = (0 < sqlsrv_rows_affected($_statement));
    sqlsrv_free_stmt($_statement);
    return $_update_status;
}

function status_update($sql_server, int $id, int $code): array
{
    $_statement = sqlsrv_query($sql_server, 'UPDATE site.users SET [status]=? WHERE Id=?', [
        $code,
        $id
    ]);
    $_update_status = (0 < sqlsrv_rows_affected($_statement));
    sqlsrv_free_stmt($_statement);
    return $_update_status;
}

function email_update($sql_server, int $id, string $email): array
{
    // Verify email doesn't exist first
    $_statement = sqlsrv_query($sql_server, 'UPDATE site.users SET email=? WHERE Id=?', [
        $email,
        $id
    ]);
    $_update_status = (0 < sqlsrv_rows_affected($_statement));
    sqlsrv_free_stmt($_statement);
    return $_update_status;
}
