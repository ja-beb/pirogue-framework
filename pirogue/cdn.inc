<?php
/**
 * CDN handler library.
 * php version 8.0.0
 * 
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @category
 * @package
 * @license
 * @version
 * @link
 */
namespace pirogue;

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
function __cdn(array $address_list): void
{
    $GLOBALS['._pirogue.cdn.current_index'] = 0;
    $GLOBALS['._pirogue.cdn.address_list'] = $address_list;
}

/**
 * Create url to resource relative to the cdn base.
 * Uses the current CDN (round robin).
 *
 * @param string $path
 *            The path to the resource.
 * @param array $data
 * @return string
 * @uses _dispatcher_create_url
 */
function cdn_create_url(string $path, array $data): string
{
    $base_url = $GLOBALS['._pirogue.cdn.address_list'][$GLOBALS['._pirogue.cdn.current_index']];
    $GLOBALS['._pirogue.cdn.current_index'] ++;
    $GLOBALS['._pirogue.cdn.current_index'] = count($GLOBALS['._pirogue.cdn.address_list']) > $GLOBALS['._pirogue.cdn.current_index'] ? $GLOBALS['._pirogue.cdn.current_index'] : 0;
    $url_pattern = empty($path) ? '%s' : '%s/%s';
    $base_url = sprintf($url_pattern, $base_url, $path);
    return (0 == count($data)) ? $base_url : sprintf('%s?%s', $base_url, http_build_query($data));
}

