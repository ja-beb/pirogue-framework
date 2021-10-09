<?php

/**
 * CDN handler library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 * A list of CDN server addresses.
 *
 * @internal used by library only.
 * @var string[] $GLOBALS['._pirogue.cdn.address_list']
 */
$GLOBALS['._pirogue.cdn.address_list'] = [];

/**
 * Current CDN array index.
 *
 * @internal used by library only.
 * @var int $GLOBALS['._pirogue.cdn.current_index']
 */
$GLOBALS['._pirogue.cdn.current_index'] = 0;

/**
 * Setup CDN library.
 *
 * @uses $GLOBALS['._pirogue.cdn.current_index']
 * @uses $GLOBALS['._pirogue.cdn.address_list']
 * @param array $address_list an array containing a list of the base CDN server addresses.
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
 *
 * @throws LogicException if there are no registered CDN servers.
 * @uses $GLOBALS['._pirogue.cdn.address_list']
 * @uses $GLOBALS['._pirogue.cdn.current_index']
 * @param string $path the path to the resource.
 * @param array $data the request data.
 * @return string url to cdn resource.
 */
function pirogue_cdn_create_url(string $path, array $data): string
{
    // If no CDN servers are registered throw exception.
    if (empty($GLOBALS['._pirogue.cdn.address_list'])) {
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
