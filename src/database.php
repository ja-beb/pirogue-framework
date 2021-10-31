<?php

/**
 * handle database connections for a MySQL backend.
 * used to open, register, retrieve, store and closing database connections.
 * translates from database name to an ini file that contains settings.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\database;

use mysqli;

/**
 * a sprintf format string of the connection ini file's path.
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
 * a list of the registered database connections.
 * @internal
 * @var array $GLOBALS['._pirogue.database.connections']
 */
$GLOBALS['._pirogue.database.connections'] = [];

/**
 * initialize library.
 * @internal
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @uses $GLOBALS['._pirogue.database.default']
 * @uses $GLOBALS['._pirogue.database.connections']
 * @param string $path_format a sprintf path_format used to find the desired database config file based on inputed name.
 * @param string $default the name of the default database.
 * @return void
 */
function _init(string $path_format, string $default): void
{
    $GLOBALS['._pirogue.database.path_format'] = $path_format;
    $GLOBALS['._pirogue.database.default'] = $default;
    $GLOBALS['._pirogue.database.connections'] = [];
}

/**
 * deallocate library variables. Will close any open connections if they exist.
 * @internal
 * @uses _close()
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @uses $GLOBALS['._pirogue.database.default']
 * @uses $GLOBALS['._pirogue.database.connections']
 * @return void
 */
function _dispose(): void
{
    if (!empty($GLOBALS['._pirogue.database.connections'])) {
        )
        _close();
    }

    unset(
        $GLOBALS['._pirogue.database.default'],
        $GLOBALS['._pirogue.database.path_format'],
        $GLOBALS['._pirogue.database.connections'],
    );
}

/**
 * close all database connection.
 * @internal
 * @uses $GLOBALS['._pirogue.database.connections']
 * @return void
 */
function _close(): void
{
    foreach (($GLOBALS['._pirogue.database.connections'] ?? []) as $connection) {
        if ('mysqli' == get_class($connection)) {
            mysqli_close($connection);
        }
    }
    $GLOBALS['._pirogue.database.connections'] = [];
}

/**
 * translates database name to the ini file's path.
 * @internal
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @param string $name name of connection to load configuration for.
 * @return ?array returns config file or null if not found.
 */
function _config(string $name): ?array
{
    $connection = false;
    $file = sprintf($GLOBALS['._pirogue.database.path_format'], $name);
    returnfile_exists($file) ? parse_ini_file($file) : null;
}

/**
 * open requested connection. translates name to the mysqli ini file's path and loads using data.
 * @internal
 * @throws error error tiggered if unable to connect or not registered.
 * @uses $GLOBALS['._pirogue.database.path_format']
 * @param string $name name of connection to open.
 * @return ?mysqli return null if not found or does not connect.
 */
function _open(string $name): ?mysqli
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
        } else {
            return $connection;
        }
    } else {
        trigger_error('database not registered');
    }
}

/**
 * get database connection. 
 * @throws error error tiggered if unable to connect or not registered.
 * @uses $GLOBALS['._pirogue.database.connections']
 * @uses $GLOBALS['._pirogue.database.default']
 * @param string $name name of database to connect. will return default if null.
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
