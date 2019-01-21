<?php 

/**
 * Primary error handler library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

namespace sprout;

use ErrorException;


/**
 *
 * @internal
 * @param int $number
 * @param string $message
 * @param string $file
 * @param int $line
 * @throws ErrorException
 * @return boolean
 */
function _error_handler(int $number, string $message, string $file, int $line)
{
    if (0 === error_reporting()) {
        return false;
    }
    throw new ErrorException($message, 0, $number, $file, $line);
}


/**
 * Write error to log.
 * @param string $message
 * @param string $file
 * @param int $line
 */
function error_handler_log($database, string $message, string $file, int $line){
    
}
