<?php 

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
function error_handler(int $number, string $message, string $file, int $line)
{
    if (0 === error_reporting()) {
        return false;
    }
    throw new ErrorException($message, 0, $number, $file, $line);
}



function error_handler_log($database_connection, string $message, string $file, int $line){
    echo $message;
    exit();
}
