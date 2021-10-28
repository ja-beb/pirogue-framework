<?php

/**
 * library for handling basic dispatcher actions.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

use ErrorException;

/**
 * the site's base address.
 *
 * @var string $GLOBALS['.pirogue.dispatcher.address']
 */
$GLOBALS['.pirogue.dispatcher.address'] = '';

/**
 * the client's requested path.
 *
 * @var string $GLOBALS['.pirogue.dispatcher.request_path']
 */
$GLOBALS['.pirogue.dispatcher.request_path'] = '';

/**
 * the client's requested data.
 *
 * @var string $GLOBALS['.pirogue.dispatcher.request_data']
 */
$GLOBALS['.pirogue.dispatcher.request_data'] = [];

/**
 * setup dispatcher library.
 *
 * @uses $GLOBALS['.pirogue.dispatcher.address']
 * @uses $GLOBALS['.pirogue.dispatcher.request_path']
 * @uses $GLOBALS['.pirogue.dispatcher.request_data']
 *
 * @param string $address the base address for the site.
 * @param string $request_path a string containing the path the the client's requested resource.
 * @param array $request_data array containing the request data passed from the client.
 * @return void
 */
function dispatcher_init(string $address, string $request_path, array $request_data): void
{
    $GLOBALS['.pirogue.dispatcher.address'] = $address;
    $GLOBALS['.pirogue.dispatcher.request_path'] = $request_path;
    $GLOBALS['.pirogue.dispatcher.request_data'] = $request_data;
}

/**
 * send content to user.
 *
 * @internal
 *
 * @param string $content the content that will be sent to the client.
 * @return void
 */
function _dispatcher_send(string $content): void
{
    ob_start('ob_gzhandler');

    //  build and send etag based on content.
    $etag = md5($content);
    header(sprintf('ETAG: %s', $etag));

    // get reesponse code.
    $http_status_code = http_response_code();
    if (false == array_key_exists('HTTP_IF_NONE_MATCH', $_SERVER)) {
        // not cached by client.
        http_response_code($http_status_code);
        echo $content;
    } elseif ($etag == $_SERVER['HTTP_IF_NONE_MATCH']) {
        // cached by client, no need to send content.
        http_response_code(200 == $http_status_code ? 304 : $http_status_code);
    } else {
        // send content.
        http_response_code($http_status_code);
        echo $content;
    }

    ob_end_flush();
}

/**
 * translate a PHP triggered errors into SPL ErrorException instance.
 *
 *
 * @throws ErrorException
 *
 * @internal registered to error handler by dispatcher.
 *
 * @param int $number the error code encountered.
 * @param string $message a message describing the error.
 * @param string $file the file the error was encountered in.
 * @param int $line the line that the error was encountered at.
 * @return boolean continuation flag.
 */
function _dispatcher_error_handler(int $number, string $message, string $file, int $line): bool
{
    if ($number & error_reporting()) {
        throw new ErrorException($message, 0, $number, $file, $line);
    }
    return false;
}

/**
 * clear all output buffers and return contents.
 *
 * @return string contents of all buffers.
 */
function _dispatcher_buffer_clear(): string
{
    $buffer = '';
    while (0 < ob_get_level()) {
        $buffer .= ob_get_clean();
    }
    return $buffer;
}

/**
 * redirect user to new address. this function calls exit() to terminated any further code execution.
 *
 * @param string $address the address to redirect too. If no address is specified the page is refreshed.
 * @param int $status_code the http status code to use in the redirect process.
 * @return void.
 */
function dispatcher_redirect(string $address, int $status_code = 301): void
{
    header(sprintf('Location: %s', $address), true, $status_code);
    exit();
}

/**
 * create url to resource relative to site base.
 *
 * @uses _dispatcher_create_url()
 * @uses $GLOBALS['.pirogue.dispatcher.address']
 *
 * @param string $path the path to the resource.
 * @param array $data an array containing key => value pairs of data use as request parameters.
 * @return string the url created from user input.
 */
function dispatcher_create_url(string $path, array $data): string
{
    return sprintf(
        match (('' == $path ? 0 : 1) | (empty($data) ? 0 : 2)) {
            0 => '%s',
            1 => '%s/%s',
            2 => '%s?%s',
            3 => '%s/%s?%s',
        },
        $GLOBALS['.pirogue.dispatcher.address'],
        $path,
        http_build_query($data)
    );
}

/**
 * get the current url.
 *
 * @uses _dispatcher_create_url()
 * @uses $GLOBALS['.pirogue.dispatcher.request_path']
 * @uses $GLOBALS['.pirogue.dispatcher.request_data']
 *
 * @return string the current requested url.
 */
function dispatcher_current_url(): string
{
    return dispatcher_create_url(
        $GLOBALS['.pirogue.dispatcher.request_path'],
        $GLOBALS['.pirogue.dispatcher.request_data']
    );
}

/**
 * convert url into a callback string to be passed as a http query variable.
 *
 * @param string $url the url to create a callback from.
 * @return string parsed callback.
 */
function dispatcher_callback_create(string $url): string
{
    return urlencode($url);
}

/**
 * parse callback string into a url.
 *
 * @param string $callback the request data.
 * @return array parsed callback in the form of a url.
 */
function dispatcher_callback_parse(string $callback): string
{
    return urldecode($callback);
}

/**
 * convert path from string to array and removes the '_' prefix that denotes a internal path name.
 *
 * @param string $path the path to convert to array.
 * @return array an array containing the path.
 */
function dispatcher_path_convert_to_array(string $path): array
{
    $result = [];
    foreach (explode('/', $path) as $key => $value) {
        $_tmp = preg_replace('/^_*/', '', $value);
        if ('' != $_tmp) {
            $result[$key] = $_tmp;
        }
    }
    return $result;
}
