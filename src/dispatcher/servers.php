<?php

/**
 * track urls for servers.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\dispatcher\servers;

/**
 * the list of registered servers.
 * @internal
 * @var array $GLOBALS['._pirogue.dispatcher.servers.list']
 */
$GLOBALS['._pirogue.dispatcher.servers.list'] = [];

/**
 * initialize the servers library.
 * @uses $GLOBALS['._pirogue.dispatcher.servers.list']
 * @internal
 * @param array $servers an assocative array of servers to register in the form of "name" => "server address"
 * @return $void
 */
function _init(array $servers = []): void
{
    $GLOBALS['._pirogue.dispatcher.servers.list'] = $servers;
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher.servers.list']
 * @return void
 */
function _dispose(): void
{
    unset($GLOBALS['._pirogue.dispatcher.servers.list']);
}

/**
 * register a new server.
 * @uses $GLOBALS['._pirogue.dispatcher.servers.list']
 * @param string $name the name of the server to register.
 * @param string $address the address of the server to register.
 * @return void.
 */
function register(string $name, string $address): void
{
    $GLOBALS['._pirogue.dispatcher.servers.list'][$name] = $address;
}

/**
 * return the url to a registered server.
 * @uses $GLOBALS['._pirogue.dispatcher.servers.list']
 * @param string $server_name the name of the server to retrieve the address of.
 * @return string url to sever or null if not registered.
 */
function url(string $server_name): ?string
{
    return $GLOBALS['._pirogue.dispatcher.servers.list'][$server_name] ?? null;
}
