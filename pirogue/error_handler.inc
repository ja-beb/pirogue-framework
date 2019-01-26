<?php

/**
 * Primary error handler library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 * Translate PHP trigger errors into SPL ErrorException instance.
 * Assigned using set_error_handler()
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
