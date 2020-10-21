<?php

/**
 * Pass notifications between pages using the client's session data.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

/**
 * @var int Confirm notice type code. 
 */
const SITE_NOTICE_CONFIRM = 0x00;

/**
 * @var int Information notice type. 
 */
const SITE_NOTICE_INFORMATION = 0x01;

/**
 * @var int Error notice flag. This should be combined with the confirm or information.
 */
const SITE_NOTICE_ERROR = 0x02;

/**
 * @var int Update notice flag. This should be combined with the confirm or information.
 */
const SITE_NOTICE_UPDATE = 0x04;

/**
 * @var int Create notice flag. This should be combined with the confirm or information.
 */
const SITE_NOTICE_CREATE = 0x08;

/**
 * @var int Delete notice flag. This should be combined with the confirm or information.
 */
const SITE_NOTICE_DELETE = 0x10;


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
function site_notices_init(string $index): void
{
    $GLOBALS['._pirogue.site_notices.index'] = $index;
    if ( false == array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION) ){
        $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    }
}

/**
 * Fetch existing notices from sessioned list and clear list.
 * @return array
 */
function page_notice_clear(): array
{
    $list = $_SESSION[$GLOBALS['._pirogue.site_notices.index']];
    $_SESSION[$GLOBALS['._pirogue.site_notices.index']] = [];
    return $list;
}

/**
 * Append site notice to list of existing notices.
 * @param int $type The code for the notice type to add.
 * @param string $message The notice's message.
 */
function page_notice_create(int $type, string $message): void
{
    array_push($_SESSION[$GLOBALS['._pirogue.site_notices.index']], [$type, $message]);
}
