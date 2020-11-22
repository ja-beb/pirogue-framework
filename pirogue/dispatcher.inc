<?php
/**
 * Primary dispatcher library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

/**
 * @var string $GLOBALS['.pirogue.dispatcher.address'] The site's base address.
 */
$GLOBALS['.pirogue.dispatcher.address'] = '';

/**
 * @var string $GLOBALS['.pirogue.dispatcher.request_path'] The path the the client's current requested resource.
 */
$GLOBALS['.pirogue.dispatcher.request_path'] = '';

/**
 * @var string $GLOBALS['.pirogue.dispatcher.request_data'] The client's requested data.
 */
$GLOBALS['.pirogue.dispatcher.request_data'] = '';

/**
 * Setup dispatcher library.
 *
 * @internal Called from dispatcher only.
 *
 * @param string $address The base address for the site.
 * @param string $request_path String containing the path the the client's requested resource.
 * @param array $request_data Array containing the request data passed from the client.
 */
function dispatcher_init(string $address, string $request_path, array $request_data): void
{
    $GLOBALS['.pirogue.dispatcher.address'] = $address;
    $GLOBALS['.pirogue.dispatcher.request_path'] = $request_path;
    $GLOBALS['.pirogue.dispatcher.request_data'] = $request_data;
}

/**
 * Send content to user and exit.
 * 
 * @internal Called from dispatcher only.
 * @uses pirogue\_dispatcher_exit
 *
 * @param string $content The content that will be sent to the client.
 */
function _dispatcher_send(string $content): void
{
    // Cache control:
    ob_start('ob_gzhandler');
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
 * Redirect user to new address.
 * 
 * @param string $address The address to redirect too. If no address is specified the page is refreshed.
 * @param ing $status_code The http status code to use in the redirect process.
 * 
 * @uses pirogue\_dispatcher_exit
 */
function dispatcher_redirect(string $address = '', int $status_code = 301): void
{
    header(
        sprintf('Location: %s', empty($address) ? $GLOBALS['.pirogue.dispatcher.address'] : $address)
            , true
            , $status_code
    );
    session_id() && session_write_close();
    _dispatcher_exit();
}

/**
 * Create url to resource relative to site base.
 *
 * @param string $path The path to the resource.
 * @param array $data
 * @return string
 * @uses _dispatcher_create_url
 */
function dispatcher_create_url(string $path, array $data): string
{
    $base_url = sprintf(empty($path) ? '%s' : '%s/%s'
        , $GLOBALS['.pirogue.dispatcher.address']
        , $path
    );    

    return (0 == count($data)) 
        ? $base_url 
        : sprintf('%s?%s', $base_url, http_build_query($data));
}

/**
 * Exit dispatcher - close session if open.
 *
 * @internal
 */
function _dispatcher_exit(): void
{
    session_id() && session_write_close();
    exit();
}