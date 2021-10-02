<?php

/**
 * CDN handler library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 *
 * @var string[] $GLOBALS['._pirogue.cdn.address_list'] A list of CDN server addresses.
 */
$GLOBALS['._pirogue.cdn.address_list'] = [];

/**
 *
 * @var int $GLOBALS['._pirogue.cdn.current_index'] Current CDN array index.
 */
$GLOBALS['._pirogue.cdn.current_index'] = 0;

/**
 * Setup CDN library.
 *
 * @internal Called from dispatcher only.
 *
 * @param array $address_list
 *            Array containing a list of the base CDN server addresses.
 */
function pirogue_cdn_init(array $address_list): void
{
    $GLOBALS['._pirogue.cdn.current_index'] = 0;
    $GLOBALS['._pirogue.cdn.address_list'] = $address_list;
}

/**
 * Create url to resource relative to the cdn base.
 * Allocates CDN for usaged based on a round robin scheduling.
 *
 * @param string $path
 *            The path to the resource.
 * @param array $data
 * @return string
 * @uses _dispatcher_create_url
 * @throws LogicException if there are no registered CDN servers.
 */
function pirogue_cdn_create_url(string $path, array $data): string
{
    // If no CND servers are registered throw exception.
    if ( empty($GLOBALS['._pirogue.cdn.address_list']) ){
        throw new LogicException('There are no registered CDN servers.');
    }

    $base_url = $GLOBALS['._pirogue.cdn.address_list'][$GLOBALS['._pirogue.cdn.current_index']];
    $GLOBALS['._pirogue.cdn.current_index'] ++;
    if (count($GLOBALS['._pirogue.cdn.address_list']) <= $GLOBALS['._pirogue.cdn.current_index']) {
        $GLOBALS['._pirogue.cdn.current_index'] = 0;
    }
    $url_pattern = empty($path) ? '%s' : '%s/%s';
    $base_url = sprintf($url_pattern, $base_url, $path);
    return (0 == count($data)) ? $base_url : sprintf('%s?%s', $base_url, http_build_query($data));
}
