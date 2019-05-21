<?php

/**
 * Org database functions.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace org;

/**
 * Execute a query on the org schema tables and return the results as an array.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $query
 * @param array $params
 * @return array
 */
function _org_fetch($database_connection, string $query, array $params = []): array
{
    $_sql_statement = sqlsrv_query($database_connection, $query, $params);
    $_data = [];
    if ($_sql_statement) {
        while ($_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC)) {
            array_push($_data, $_sql_row);
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return $_data;
}

/**
 * Get list of all locations.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function location_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.locations', []);
}

/**
 * Get location data by id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param int $id
 * @return array
 */
function location_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.locations where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Search for location that matches desired filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function location_lookup($database_connection, string $filter, array $params): array
{
    return _org_fetch($database_connection, sprintf('select * from org.locations where %s', $filter), $params);
}

/**
 * Get list of all positions.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.positions', []);
}

/**
 * Get position data by id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param int $id
 * @return array
 */
function position_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.positions where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Search for position that matches desired filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function position_lookup($database_connection, string $filter, array $params): array
{
    return _org_fetch($database_connection, sprintf('select * from org.positions where %s', $filter), $params);
}

/**
 * Get list of departments.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function department_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.departments', []);
}

/**
 * Fetch department by id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param int $id
 * @return array
 */
function department_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.departments where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Search for department using user filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function department_lookup($database_connection, string $filter, array $params): array
{
    return _org_fetch($database_connection, sprintf('select * from org.departments where %s', $filter), $params);
}

/**
 * Fetch list of divisions.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function division_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.divisions', []);
}

/**
 * Fetch division using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param int $id
 * @return array
 */
function division_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.divisions where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Fetch division using filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @param string $filter
 * @param array $params
 * @return array
 */
function division_lookup($database_connection, string $filter, array $params): array
{
    return _org_fetch($database_connection, sprintf('select * from org.divisions where %s', $filter), $params);
}

/**
 * Fetch list of pay grades from database.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_pay_grades_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.position_pay_grades', []);
}

/**
 * Fetch pay grade from database using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_pay_grades_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.position_pay_grades where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Fetch list of pay grades from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_pay_grades_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.position_pay_grades where %s', $filter), $params);
}

/**
 * Fetch list of location types from database..
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function location_types_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.location_types', []);
}

/**
 * Fetch pay grade from database using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function location_types_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.location_types where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Fetch list of pay grades from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function location_types_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.location_types where %s', $filter), $params);
}

/**
 * Fetch list of position assignments from database.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_assignments_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.position_assignments', []);
}

/**
 * Fetch a position assignment from database using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_assignments_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.position_assignments where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Fetch list of position assignment from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function position_assignments_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.position_assignments where %s', $filter), $params);
}

/**
 * Fetch list of pay rates from database.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function pay_rates_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.pay_rates', []);
}

/**
 * Fetch a pay rate from database using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function pay_rates_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.pay_rates where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Fetch list of pay rates from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function pay_rates_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.pay_rates where %s', $filter), $params);
}

/**
 * Fetch list of employees from database.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employees_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.employee_details', []);
}

/**
 * Fetch a employees from database using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employees_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.employee_details where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}

/**
 * Fetch list of employees from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employees_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.employee_details where %s', $filter), $params);
}

/**
 * Fetch list of employee phone numbers from database.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employee_phone_numbers_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.employee_phone_numbers', []);
}

/**
 * Fetch list of employee phone numbers from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employee_phone_numbers_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.employee_phone_numbers where %s', $filter), $params);
}

/**
 * Fetch list of employment history types from database.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employment_history_records_list($database_connection): array
{
    return _org_fetch($database_connection, 'select * from org.employment_history_records', []);
}

/**
 * Fetch a employment history from database using id number.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employment_history_records_fetch($database_connection, int $id): ?array
{
    $_list = _org_fetch($database_connection, 'select * from org.employment_history_records where id=?', [
        $id
    ]);
    return $_list[0] ?? null;
}


/**
 * Fetch list of employment history numbers from database using a filter.
 *
 * @param resource $database_connection
 *            SQL Server database connection.
 * @return array
 */
function employment_history_records_lookup($database_connection, string $filter, $params = null): array
{
    return _org_fetch($database_connection, sprintf('select * from org.employment_history_records where %s', $filter), $params);
}


