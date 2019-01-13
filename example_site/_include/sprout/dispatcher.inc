<?php
namespace sprout;


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
$GLOBALS['._dispatcher_cache_control'] = 0x00;

/**
 *
 * @var int $GLOBALS['._cache_control']
 */
$GLOBALS['._dispatcher_cache_control_max_age'] = 0;

/**
 *
 * @param int $code
 */
function dispatcher_set_cache_control(int $code, int $max_age = 0)
{
    $GLOBALS['._dispatcher_cache_control'] = $code;
    $GLOBALS['._dispatcher_cache_control_max_age'] = $max_age;
}

/**
 * dispatcher address.
 *
 * @var string
 */
$GLOBALS['.dispatcher_address'] = '';

/**
 *
 * @param string $address
 */
function __dispatcher(string $address)
{
    $GLOBALS['.dispatcher_address'] = $address;
}


/**
 * Send content to user then exit.
 *
 * @param string $content
 */
function _dispatcher_cache():string 
{
    // Cache control:
    if (0x01 != ($GLOBALS['._dispatcher_cache_control'] & 0x01)) {
        return 'no-cache, no-store';
    } 
    
    
    if (0x02 == ($GLOBALS['._dispatcher_cache_control'] & 0x02)) {
        $cache = 'public';
    } else {
        $cache = 'private';
    }
    
    if (CACHE_CONTROL_REVALUATE == (CACHE_CONTROL_REVALUATE & $GLOBALS['._dispatcher_cache_control'])) {
        $cache = "{$cache}, proxy-revalidate";
    }
    
    if (CACHE_CONTROL_STORE == (CACHE_CONTROL_STORE & $GLOBALS['._dispatcher_cache_control'])) {
        $cache = "{$cache}, no-store";
    }
    
    switch ($GLOBALS['._dispatcher_cache_control_max_age']) {
        case - 1:
            $max_age = ';max-age=86400';
            break;
            
        case 0:
            $max_age = sprintf(';max-age=%d', $GLOBALS['._dispatcher_cache_control_max_age']);
            break;
            
        default:
            $max_age = sprintf(';max-age=%d', $GLOBALS['._dispatcher_cache_control_max_age']);
            break;
    }
    return  "{$cache}{$max_age}";
    
}

/**
 * Send content to user then exit.
 *
 * @param string $content
 */
function dispatcher_send(string $content)
{
    // Cache control:
    if (0x01 != ($GLOBALS['._dispatcher_cache_control'] & 0x01)) {
        $cache = 'no-cache, no-store';
    } elseif (0x02 == ($GLOBALS['._dispatcher_cache_control'] & 0x02)) {
        $cache = 'public';
    } else {
        $cache = 'private';
    }

    if (CACHE_CONTROL_REVALUATE == (CACHE_CONTROL_REVALUATE & $GLOBALS['._dispatcher_cache_control'])) {
        $cache = "{$cache}, proxy-revalidate";
    }

    if (CACHE_CONTROL_STORE == (CACHE_CONTROL_STORE & $GLOBALS['._dispatcher_cache_control'])) {
        $cache = "{$cache}, no-store";
    }

    switch ($GLOBALS['._dispatcher_cache_control_max_age']) {
        case - 1:
            $max_age = ';max-age=86400';
            break;

        case 0:
            $max_age = sprintf(';max-age=%d', $GLOBALS['._dispatcher_cache_control_max_age']);
            break;

        default:
            $max_age = sprintf(';max-age=%d', $GLOBALS['._dispatcher_cache_control_max_age']);
            break;
    }
    header("Cache-Control: {$cache}{$max_age}");

    $etag = md5($content);
    header("ETAG: {$etag}");
    if (false == array_key_exists('HTTP_IF_NONE_MATCH', $_SERVER)) {
        http_response_code(200);
        echo $content;
    } elseif ($etag == $_SERVER['HTTP_IF_NONE_MATCH']) {
        http_response_code(304);
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

