<?php

namespace org;

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

