<?php

/**
 * store and create urls for cdn resources.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\cdn;

/**
 * registered cdn servers.
 * @internal
 * @var string[] $GLOBALS['._pirogue.cdn.servers']
 */
$GLOBALS['._pirogue.cdn.servers'] = [];

/**
 * initialize the cdn library.
 * @uses $GLOBALS['._pirogue.cdn.current_index']
 * @uses $GLOBALS['._pirogue.cdn.servers']
 * @internal
 * @param array $servers an assocative array of servers to register.
 * @return $void
 */
function _init(array $servers = []): void
{
    $GLOBALS['._pirogue.cdn.servers'] = [];
    foreach ($servers as $name => $address) {
        register($name, $address);
    }
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.cdn.current_index']
 * @uses $GLOBALS['._pirogue.cdn.servers']
 * @return void
 */
function _dispose(): void
{
    unset(
        $GLOBALS['._pirogue.cdn.servers'],
    );
}

/**
 * registger new cdn server.
 * @uses $GLOBALS['._pirogue.cdn.servers']
 * @param string $name the name of the serer to register.
 * @param string $address the address of the server to register.
 * @return void.
 */
function register(string $name, string $address): void
{
    $GLOBALS['._pirogue.cdn.servers'][$name] = $address;
}

/**
 * create url to resource relative to the cdn base using registered cdn.
 * @uses $GLOBALS['._pirogue.cdn.servers']
 * @param string $server_name the name of the server to retrieve the address of.
 * @return string url to cdn sever
 */
function url(string $server_name): ?string
{
    return $GLOBALS['._pirogue.cdn.servers'][$server_name] ?? null;
}
