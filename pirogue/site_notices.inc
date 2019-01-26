<?php

/**
 * Site notifications
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

// 0, 1, 2
define('SITE_NOTICE_INFORMATION', 0x01);
define('SITE_NOTICE_CONFIRM', 0x00);
define('SITE_NOTICE_ERROR', 0x03);


define('SITE_NOTICE_FAILED', 0x02);
define('SITE_NOTICE_SUCCESS', 0x03);

define('SITE_NOTICE_UPDATE', 0x01);
define('SITE_NOTICE_CREATE', 0x01);
define('SITE_NOTICE_DELETE', 0x01);


/**
 * Site notices index in session array.
 * @internal
 * @var string $GLOBALS['._pirogue.site_notices.index']
 */
$GLOBALS['._pirogue.site_notices.index'] = '';

/**
 * Setup site notices.
 * @param string $index Session array index for site notices.
 */
function __site_notices(string $index)
{
    $GLOBALS['._pirogue.site_notices.index'] = $index;
    if ( false == array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION) ){
        $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    }
}

/**
 * 
 * @return array
 */
function page_notice_clear(): array
{
    $list = $_SESSION[$GLOBALS['._pirogue.site_notices.index']];
    $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    return $list;
}

/**
 * 
 * @param int $type
 * @param string $message
 */
function page_notice_create(int $type, string $message)
{
    array_push($_SESSION[$GLOBALS['._pirogue.site_notices.index']], [$type, $message]);
}
