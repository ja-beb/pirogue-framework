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
function employee_fetch($sql_server, string $filter, string $id): array
{
    $_statement = sqlsrv_query($sql_server, sprintf('select employees.id, employees.employee_number, employees.name_given
		, employees.name_middle, employees.name_surname, employees.name_generation_qualifier, employees.name_title
		, employees.gender, employees.date_of_birth, employees.ssn, email_address
	from org.employees
		left join org.employee_accounts on employees.id=employee_accounts.employee_id where %s', $filter), [$id]);
    if ( $_statement ){
        $_data = sqlsrv_fetch_array($_statement, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($_statement);
    }else{
        $_data = [];
    }
    return $_data ?? [];
}
