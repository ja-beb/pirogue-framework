<?php

/**
 * Site notifications
 */
namespace sprout;

// 0, 1, 2
define('SITE_NOTICE_INFORMATION', 0x01);
define('SITE_NOTICE_CONFIRM', 0x00);
define('SITE_NOTICE_ERROR', 0x03);


define('SITE_NOTICE_FAILED', 0x02);
define('SITE_NOTICE_SUCCESS', 0x03);

define('SITE_NOTICE_UPDATE', 0x01);
define('SITE_NOTICE_CREATE', 0x01);
define('SITE_NOTICE_DELETE', 0x01);

function _page_notice_init(string $index)
{}

function page_notice_clear(): array
{
    return [];
}

function page_notice_create(int $type, string $message)
{}
