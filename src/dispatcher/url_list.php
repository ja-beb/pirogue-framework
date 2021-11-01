<?php

/**
 * track urls for urls used by site.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\dispatcher\url_list;

/**
 * the list of registered urls.
 * @internal
 * @var array $GLOBALS['._pirogue.dispatcher.url_list.list']
 */
$GLOBALS['._pirogue.dispatcher.url_list.list'] = [];

/**
 * initialize the url list library.
 * @uses $GLOBALS['._pirogue.dispatcher.url_list.list']
 * @internal
 * @param array $list an assocative array of urls to register in the form of "name" => "server address"
 * @return $void
 */
function _init(array $list = []): void
{
    $GLOBALS['._pirogue.dispatcher.url_list.list'] = $list;
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher.url_list.list']
 * @return void
 */
function _dispose(): void
{
    unset($GLOBALS['._pirogue.dispatcher.url_list.list']);
}

/**
 * register a new server.
 * @uses $GLOBALS['._pirogue.dispatcher.url_list.list']
 * @param string $name the name of the server to register.
 * @param string $address the address of the server to register.
 * @return void.
 */
function register(string $name, string $address): void
{
    $GLOBALS['._pirogue.dispatcher.url_list.list'][$name] = $address;
}

/**
 * return the url to a registered server.
 * @uses $GLOBALS['._pirogue.dispatcher.url_list.list']
 * @param string $server_name the name of the server to retrieve the address of.
 * @return string url to sever or null if not registered.
 */
function url(string $server_name): ?string
{
    return $GLOBALS['._pirogue.dispatcher.url_list.list'][$server_name] ?? null;
}
