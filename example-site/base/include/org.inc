<?php

namespace org;

define('_ORG_EMPLOYEE_FETCH_FILTER_ID', 'id=?');
define('_ORG_EMPLOYEE_FETCH_FILTER_EMAIL', 'email_address=?');


function org_list($database_connection, string $table): array{
    $_sql_statement = sqlsrv_query($database_connection, sprintf('select * from org.%s', $table));
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
}


function org_fetch($database_connection, string $table, int $id): array{
    $_sql_statement = sqlsrv_query($database_connection, sprintf('select * from org.%s where id=%d', $table, $id));
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
}


function org_find($database_connection, string $table, string $filter, string $value): array{
    $_sql_statement = sqlsrv_query($database_connection, sprintf('select * from org.%s where %s=?', $table, $filter), [$value]);
    $_data = [];
    if ( $_sql_statement ){
        while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
            array_push($_data , $_sql_row);
        }
        sqlsrv_free_stmt($_sql_statement);
    }
    return $_data;
}








function position_list($database_connection): array{
    $_sql_statement = sqlsrv_query($database_connection, 'select * from org.positions');
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
    
}

function position_fetch($database_connection, int $id): array{
    $_sql_statement = sqlsrv_query($database_connection, sprintf('select * from org.positions where id=%d',$id));
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
}


function department_list($database_connection): array{
    $_sql_statement = sqlsrv_query($database_connection, 'select * from org.departments');
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
    
}

function department_fetch($database_connection, int $id): array{
    $_sql_statement = sqlsrv_query($database_connection, sprintf('select * from org.departments where id=%d',$id));
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
}


function division_list($database_connection): array{
    $_sql_statement = sqlsrv_query($database_connection, 'select * from org.divisions');
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
    
}

function division_fetch($database_connection, int $id): array{
    $_sql_statement = sqlsrv_query($database_connection, sprintf('select * from org.divisions where id=%d',$id));
    $_data = [];
    while ( $_sql_row = sqlsrv_fetch_array($_sql_statement, SQLSRV_FETCH_ASSOC) ){
        array_push($_data , $_sql_row);
    }
    sqlsrv_free_stmt($_sql_statement);
    return $_data;
}


