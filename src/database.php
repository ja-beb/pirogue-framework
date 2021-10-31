<?php

/**
 * database connections for a MySQL backend.
 * handles the opening, storing, retrieving and closing of database connections
 * by translating requested name into config file.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\database;

use mysqli;

/**
 * a sprintf format string used to build file path based on inputed name.
 * @internal
 * @var string $GLOBALS['._pirogue.database.path_format']
 */
$GLOBALS['._pirogue.database.path_format'] = null;

/**
 * default database connection that used.
 * @internal
 * @var string $GLOBALS['._pirogue.database.default']
 */
$GLOBALS['._pirogue.database.default'] = '';

/**
 * registered database connections.
 * @internal
 * @var array $GLOBALS['._pirogue.database.connections']
 */
$GLOBALS['._pirogue.database.connections'] = [];

/**
 * initialize database collection library.
 * @internal
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @uses $GLOBALS['._pirogue.database.default']
 * @uses $GLOBALS['._pirogue.database.connections']
 * @uses _dispose()
 * @param string $path_format a sprintf path_format used to find the desired database config file based on inputed name.
 * @param string $default the name of the default database.
 * @return void
 */
function _init(string $path_format, string $default): void
{
    $GLOBALS['._pirogue.database.path_format'] = $path_format;
    $GLOBALS['._pirogue.database.default'] = $default;
    $GLOBALS['._pirogue.database.connections'] = [];

    // register destruct function.
    register_shutdown_function('pirogue\database\_dispose');
}

/**
 * close and deallocate all registered mysqli connections.
 * @internal
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @uses $GLOBALS['._pirogue.database.default']
 * @uses $GLOBALS['._pirogue.database.connections']
 * @return void
 */
function _dispose(): void
{
    if (array_key_exists('._pirogue.database.connections', $GLOBALS)) {
        foreach ($GLOBALS['._pirogue.database.connections'] as $connection) {
            if ('mysqli' == get_class($connection)) {
                mysqli_close($connection);
            }
        }
        unset(
            $GLOBALS['._pirogue.database.default'],
            $GLOBALS['._pirogue.database.path_format'],
            $GLOBALS['._pirogue.database.connections'],
        );
    }
}

/**
 * open requested connection
 * @internal
 * @throws error error tiggered if unable to connect or not registered.
 * @uses $connection()
 * @param string $name name of connection to open.
 * @return ?mysqli return null if not found or does not connect.
 */
function _open(string $name): mysqli
{
    $connection = false;
    $file = sprintf($GLOBALS['._pirogue.database.path_format'], $name);
    if (file_exists($file)) {
        $config = parse_ini_file($file);
        $connection = mysqli_connect(
            $config['host'] ?? null,
            $config['username'] ?? null,
            $config['password'] ?? null,
            $config['dbname'] ?? '',
            $config['port'] ?? '3306',
            $config['socket'] ?? null
        );
        if (false == $connection) {
            trigger_error('unable to connect');
        }
        return $connection;
    } else {
        trigger_error('database not registered');
    }
}

/**
 * fetch a registerd database connection or register a new connection.
 * @throws error error tiggered if unable to connect or not registered.
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @uses $GLOBALS['._pirogue.database.connections']
 * @uses $GLOBALS['._pirogue.database.default']
 * @param string $name
 * @return mysqli resource item.
 */
function get(?string $name = null): mysqli
{
    $name = null == $name ? $GLOBALS['._pirogue.database.default'] : $name;
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database.connections'])) {
        $GLOBALS['._pirogue.database.connections'][$name] = _open($name);
    }
    return $GLOBALS['._pirogue.database.connections'][$name];
}
