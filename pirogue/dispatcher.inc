<?php
/**
 * Primary dispatcher library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 * Dispatcher's base address.
 *
 * @var string $GLOBALS['.pirogue.dispatcher.address']
 */
$GLOBALS['.pirogue.dispatcher.address'] = '';

/**
 * Setup dispatcher library.
 *
 * @param string $address
 */
function __dispatcher(string $address)
{
    $GLOBALS['.pirogue.dispatcher.address'] = $address;
}

/**
 * Send content to user then exit.
 *
 * @internal Called from dispatcher only.
 * @param string $content
 */
function _dispatcher_send(string $content)
{
    // Cache control:
    header('Cache-Control: private, proxy-revalidate;max-age=0');

    $etag = md5($content);
    header("ETAG: {$etag}");
    $http_status_code = http_response_code();
    if (false == array_key_exists('HTTP_IF_NONE_MATCH', $_SERVER)) {
        http_response_code($http_status_code);
        echo $content;
    } elseif ($etag == $_SERVER['HTTP_IF_NONE_MATCH']) {
        http_response_code((200 == $http_status_code) ? 304 : $http_status_code);
    } else {
        http_response_code($http_status_code);
        echo $content;
    }
    exit();
}

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
function _dispatcher_error_handler(int $errno, string $errstr, string $errfile, int $errline): bool
{
    if ($errno & error_reporting()) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    return false;
}

/**
 * Redirect user to new address.
 */
function dispatcher_redirect(string $address, int $code = 301)
{
    header("Location: {$address}", true, $code);
    exit();
}
