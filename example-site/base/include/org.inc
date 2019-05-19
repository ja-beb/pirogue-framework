<?php

/**
 * Org database functions.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

namespace org;

/**
 * Execute a query on the org schema tables and return the results as an array.
 * @param resource $database_connection SQL Server database connection.
 * @param string $query 
 * @param array $params
 * @return array
 */
function _org_fetch($database_connection, string $query, array $params = []): array{
    $_sql_statement = sqlsrv_query($database_connection, $query, $params);
    $_data = [];
    if ( $_sql_statement )
    {
        while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
            array_push($_data , $_sql_row);
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return $_data;
}

/**
 * Get list of all positions.
 * @param resource $database_connection SQL Server database connection.
 * @return array
 */
function position_list($database_connection): array{
    return _org_fetch($database_connection, 'select * from org.positions', []);
}

/**
 * Get position data by id number.
 * @param resource $database_connection SQL Server database connection.
 * @param int $id
 * @return array
 */
function position_fetch($database_connection, int $id): ?array{
    $_position = _org_fetch($database_connection,'select * from org.positions where id=?', [$id]);
    return $_position[0] ?? null;
}

/**
 * Search for position that matches desired filter. 
 * @param resource $database_connection SQL Server database connection. 
 * @param string $filter
 * @param array $params
 * @return array
 */
function position_lookup($database_connection, string $filter, array $params): array{
    return _org_fetch($database_connection, sprintf('select * from org.positions where %s', $filter), $params);
}

/**
 * Get list of departments. 
 * @param resource $database_connection SQL Server database connection. 
 * @return array
 */
function department_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.departments',[]);
}

/**
 * Fetch department by id number.
 * @param resource $database_connection SQL Server database connection. 
 * @param int $id
 * @return array
 */
function department_fetch($database_connection, int $id): ?array{
    $_department = _org_fetch($database_connection,'select * from org.departments where id=?', [$id]);
    return $_department[0] ?? null;
}

/**
 * Search for department using user filter.
 * @param resource $database_connection SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function department_lookup($database_connection, string $filter, array $params): array{
    return _org_fetch($database_connection,sprintf('select * from org.departments where %s', $filter), $params);
}

/**
 * Fetch list of divisions.
 * @param resource $database_connection SQL Server database connection.
 * @return array
 */
function division_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.divisions',[]);
}

/**
 * Fetch division using id number.
 * @param resource $database_connection SQL Server database connection.
 * @param int $id
 * @return array
 */
function division_fetch($database_connection, int $id): ?array{
    $_division = _org_fetch($database_connection,'select * from org.divisions where id=?', [$id]);
    return $_division[0] ?? null;
}

/**
 * Fetch division using filter.
 * @param resource $database_connection SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function division_lookup($database_connection, string $filter, array $params): array{
    return _org_fetch($database_connection, sprintf('select * from org.divisions where %s', $filter), $params);
}



// select * from org.position_pay_grades;
function position_pay_grades_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.position_pay_grades',[]);
}

function position_pay_grades_fetch($database_connection, int $id): array{
    return _org_fetch($database_connection,'select * from org.position_pay_grades',[]);
}

function position_pay_grades_lookup($database_connection, string $filer, $params = null): array{
    return _org_fetch($database_connection,'select * from org.position_pay_grades',[]);
}




// select * from org.location_types;
function location_types_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.location_types',[]);
}


// select * from org.position_assignments;
function position_assignments_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.position_assignments',[]);
}

// select * from org.pay_rates
function pay_rates_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.pay_rates',[]);
}



// select * from org.employees;
function employees_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.employeess',[]);
}

// select * from org.employee_accounts
function employee_accounts_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.employee_accounts',[]);
}

// select * from org.employee_phone_numbers
function employee_phone_numbers_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.employee_phone_numbers',[]);
}

// select * from org.employment_history_records
function employment_history_records_list($database_connection): array{
    return _org_fetch($database_connection,'select * from org.employment_history_records',[]);
}




