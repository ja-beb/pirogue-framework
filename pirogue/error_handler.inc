<?php
/**
 * Site error handler functions.
 * php version 8.0.0
 * 
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @category
 * @package
 * @license
 * @version
 * @link
 */

/**
 * Translate PHP trigger errors into SPL ErrorException instance.
 *
 * @internal
 * @throws ErrorException
 *
 * @param int $number
 *            The error code encountered.
 * @param string $message
 *            A message describing the error.
 * @param string $file
 *            The file the error was encountered in.
 * @param int $line
 *            The line that the error was encountered at.
 *            
 * @return boolean
 */
function _pirogue_error_handler(int $number, string $message, string $file, int $line): bool
{
    if ($number & error_reporting()) {
        throw new ErrorException($message, 0, $number, $file, $line);
    }
    return false;
}

/**
 * Write error message to the site's error log.
 *
 * @param string $message
 *            The message to write to log.
 * @param string $file
 *            The file the error was encountered in.
 * @param int $line
 *            The line that the error was encountered at.
 */
function pirogue_error_handler_log(string $message, string $file, int $line): void
{
    error_log(sprintf('PHP Error encountered: "%s" - %s (%d).', $message, $file, $line));
}