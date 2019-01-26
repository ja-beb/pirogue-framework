<?php
/**
 * Primary dispatcher library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

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
$GLOBALS['._pirogue.dispatcher.cache_control'] = CACHE_CONTROL_TYPE_PUBLIC;

/**
 *
 * @var int $GLOBALS['._pirogue.dispatcher.cache_control_max_age']
 */
$GLOBALS['._pirogue.dispatcher.cache_control_max_age'] = 0;

/**
 * Dispatcher address.
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
 * @internal
 * @param string $content
 */
function _dispatcher_cache(): string
{
    // Cache control:
    if (CACHE_CONTROL_DISABLED == $GLOBALS['._pirogue.dispatcher.cache_control']) {
        return 'no-cache, no-store';
    }

    $cache = (CACHE_CONTROL_TYPE_PRIVATE == ($GLOBALS['._pirogue.dispatcher.cache_control'] & CACHE_CONTROL_TYPE_PRIVATE)) ? 'public' : 'private';

    if (CACHE_CONTROL_REVALUATE == (CACHE_CONTROL_REVALUATE & $GLOBALS['._pirogue.dispatcher.cache_control'])) {
        $cache = "{$cache}, proxy-revalidate";
    }

    if (CACHE_CONTROL_STORE == (CACHE_CONTROL_STORE & $GLOBALS['._pirogue.dispatcher.cache_control'])) {
        $cache = "{$cache}, no-store";
    }

    switch ($GLOBALS['._pirogue.dispatcher.cache_control_max_age']) {
        case - 1:
            $max_age = ';max-age=86400';
            break;

        default:
            $max_age = sprintf(';max-age=%d', $GLOBALS['._pirogue.dispatcher.cache_control_max_age']);
            break;
    }
    return "{$cache}{$max_age}";
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
    header(sprintf('Cache-Control: %s', _dispatcher_cache()));

    $etag = md5($content);
    header("ETAG: {$etag}");
    $http_status_code = http_response_code();
    if (false == array_key_exists('HTTP_IF_NONE_MATCH', $_SERVER)) {
        http_response_code($http_status_code);
        echo $content;
    } elseif ($etag == $_SERVER['HTTP_IF_NONE_MATCH']) {
        http_response_code((200 == $http_status_code) ? 304 : $http_status_code);
    }
    exit();
}

/**
 * Redirect user to new address.
 */
function dispatcher_redirect(string $address, int $code = 301)
{
    header("Location: {$address}", true, $code);
    exit();
}

/**
 *
 * @param int $code
 */
function dispatcher_set_cache_control(int $code, int $max_age = 0)
{
    $GLOBALS['._pirogue.dispatcher.cache_control'] = $code;
    $GLOBALS['._pirogue.dispatcher.cache_control_max_age'] = $max_age;
}