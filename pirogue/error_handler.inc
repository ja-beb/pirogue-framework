<?php

/**
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 * Translate PHP trigger errors into SPL ErrorException instance.
 *
 * @internal
 * @param int $number
 * @param string $message
 * @param string $file
 * @param int $line
 * @throws ErrorException
 * @return boolean
 */
function _error_handler(int $errno, string $errstr, string $errfile, int $errline): bool
{
    if ($errno & error_reporting()) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    return false;
}

/**
 * Log error.
 *
 * @param resource $database
 *            SQL Server connection.
 * @param string $message
 * @param string $file
 * @param int $line
 */
function error_handler_log($database, string $message, string $file, int $line)
{
    sqlsrv_query($database, 'insert into site.errors([timestamp], [message], [file], line) values(current_timestamp,?,?,?)', [
        $message,
        $file,
        $line
    ]);
}