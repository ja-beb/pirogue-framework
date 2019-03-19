<?php
/**
 * Primary dispatcher library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 *
 * @var int
 */
define('CACHE_CONTROL_DISABLED', 0x00);

/**
 *
 * @var int
 */
define('CACHE_CONTROL_TYPE_PRIVATE', 0x01);

/**
 *
 * @var int
 */
define('CACHE_CONTROL_TYPE_PUBLIC', 0x03);

/**
 *
 * @var int
 */
define('CACHE_CONTROL_REVALUATE', 0x04);

/**
 *
 * @var int
 */
define('CACHE_CONTROL_STORE', 0x08);

/**
 *
 * @var int $GLOBALS['._cache_control']
 */
$GLOBALS['._pirogue.dispatcher.cache_control'] = CACHE_CONTROL_TYPE_PRIVATE;

/**
 *
 * @var int $GLOBALS['._pirogue.dispatcher.cache_control_max_age']
 */
$GLOBALS['._pirogue.dispatcher.cache_control_max_age'] = 0;

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
 * Build cache control directive.
 *
 * @internal
 * @param int $cache_control The cache control code to check.
 * @param int $max_age The max age of the cache. If number is less than zero then the max age is set to one day (86400).
 */
function _dispatcher_cache(int $cache_control, int $max_age): string
{
    // Cache control:
    if (CACHE_CONTROL_DISABLED == $cache_control) {
        return 'no-cache, no-store';
    }

    $cache = (CACHE_CONTROL_TYPE_PRIVATE == ($cache_control & CACHE_CONTROL_TYPE_PRIVATE)) ? 'private' : 'public';

    if (CACHE_CONTROL_REVALUATE == (CACHE_CONTROL_REVALUATE & $cache_control)) {
        $cache = "{$cache}, proxy-revalidate";
    }

    if (CACHE_CONTROL_STORE == (CACHE_CONTROL_STORE & $cache_control)) {
        $cache = "{$cache}, no-store";
    }

    return sprintf('%s;max-age=%d', $cache, ( 0 > $max_age) ? 86400 : $max_age );
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
    header(sprintf('Cache-Control: %s', _dispatcher_cache($GLOBALS['._pirogue.dispatcher.cache_control'], $GLOBALS['._pirogue.dispatcher.cache_control_max_age'])));

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
