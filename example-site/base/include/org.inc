<?php

namespace org;

define('_ORG_EMPLOYEE_FETCH_FILTER_ID', 'id=?');
define('_ORG_EMPLOYEE_FETCH_FILTER_EMAIL', 'email_address=?');

/**
 * get site user
 * @param resource $sql_server
 *            SQL Server Connection
 * @param int $id
 * @return array
 */
function employee_fetch($sql_server, int $id): array
{
    return _fetch($sql_server, 'id=?', [
        $id
    ]);
}
