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
 * Requested path.
 *
 * @var string $GLOBALS['.pirogue.dispatcher.request_path']
 */
$GLOBALS['.pirogue.dispatcher.request_path'] = '';

/**
 * Requested data.
 *
 * @var string $GLOBALS['.pirogue.dispatcher.request_data']
 */
$GLOBALS['.pirogue.dispatcher.request_data'] = '';

/**
 * Setup dispatcher library.
 *
 * @internal Caled from dispatcher only.
 * @param string $address
 */
function __dispatcher(string $address, string $request_path, array $request_data)
{
    $GLOBALS['.pirogue.dispatcher.address'] = $address;
    $GLOBALS['.pirogue.dispatcher.request_path'] = $request_path;
    $GLOBALS['.pirogue.dispatcher.request_data'] = $request_data;
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
    ob_start('ob_gzhandler');
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
    ob_end_flush();
    _dispatcher_exit();
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
function dispatcher_redirect(string $address = '', int $code = 301)
{
    $address = empty($address) ? $GLOBALS['.pirogue.dispatcher.address'] : $address;
    header("Location: {$address}", true, $code);
    session_id() && session_write_close();
    _dispatcher_exit();
}

/**
 * Create url to resource relative to site base.
 *
 * @param string $path
 * @param array $data
 * @return string
 * @uses _dispatcher_create_url
 */
function dispatcher_create_url(string $path = null, array $data = []): string
{
    // if no input provided use current request
    if (0 == count(func_get_args())) {
        $path = $GLOBALS['.pirogue.dispatcher.request_path'];
        $data = $GLOBALS['.pirogue.dispatcher.request_data'];
    }

    $_url = sprintf(empty($path) ? '%s' : '%s/%s', $GLOBALS['.pirogue.dispatcher.address'], $path);
    if (0 < count($data)) {
        $_url = sprintf('%s?%s', $_url, http_build_query($data));
    }
    return $_url;
}


/**
 * Exit dispatcher - close session if open.
 * @internal
 */
function _dispatcher_exit()
{
    session_id() && session_write_close();
    exit();
}