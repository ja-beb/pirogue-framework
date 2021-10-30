<?php

/**
 * database connections for a MySQL backend.
 * handles the opening, storing, retrieving and closing of database connections
 * by translating requested name into config file.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\database_collection;

use mysqli;

/**
 * a sprintf format string used to build file path based on inputed name.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.database_collection.pattern']
 */
$GLOBALS['._pirogue.database_collection.pattern'] = null;

/**
 * default database connection.
 * used when no database is specified (or in single database sites).
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.database_collection.default']
 */
$GLOBALS['._pirogue.database_collection.default'] = '';

/**
 * open database connections.
 *
 * @internal used by library only.
 * @var array $GLOBALS['._pirogue.database_collection.connections']
 */
$GLOBALS['._pirogue.database_collection.connections'] = [];

/**
 * initialize database collection library.
 *
 * @uses $GLOBALS['._pirogue.database_collection.pattern']
 * @uses $GLOBALS['._pirogue.database_collection.default']
 * @uses $GLOBALS['._pirogue.database_collection.connections']
 *
 * @param string $pattern a sprintf pattern used to find the desired database config file based on inputed name.
 * @param string $default the name of the default database.
 */
function _init(string $pattern, string $default): void
{
    $GLOBALS['._pirogue.database_collection.pattern'] = $pattern;
    $GLOBALS['._pirogue.database_collection.default'] = $default;
    $GLOBALS['._pirogue.database_collection.connections'] = [];

    // register destruct function.
    register_shutdown_function('pirogue\database_collection\_dispose');
}

/**
 * close and deallocate all registered mysqli connections.
 *
 * @internal used by library only.
 * @uses $GLOBALS['._pirogue.database_collection.connections']
 *
 * @return void
 */
function _dispose(): void
{
    if (array_key_exists('._pirogue.database_collection.connections', $GLOBALS)) {
        foreach ($GLOBALS['._pirogue.database_collection.connections'] as $connection) {
            if ('mysqli' == get_class($connection)) {
                mysqli_close($connection);
            }
        }
        unset($GLOBALS['._pirogue.database_collection.connections']);
    }
}

/**
 * fetch a registerd database connection.
 * this function will fetch a previously opened database connection or create and save a new connection based on name by
 * translating nane to a config file using library's pattern. This function will trigger an error if no connection is found.
 *
 * @uses $GLOBALS['._pirogue.database_collection.pattern']
 * @uses $GLOBALS['._pirogue.database_collection.connections']
 * @uses $GLOBALS['._pirogue.database_collection.default']
 * @uses trigger_error()
 *
 * @param string $name
 * @return mysqli resource item.
 */
function get_connection(?string $name = null): mysqli
{
    // use default if not specified.
    $name = null == $name ? $GLOBALS['._pirogue.database_collection.default'] : $name;

    // check for connection - if not open and register.
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database_collection.connections'])) {
        // load config file.
        $file = sprintf($GLOBALS['._pirogue.database_collection.pattern'], $name);
        if (!file_exists($file)) {
            trigger_error(sprintf('Unable to find database connection "%s"', $name));
        }
        $config = parse_ini_file($file);

        // open connection.
        $GLOBALS['._pirogue.database_collection.connections'][$name] = mysqli_connect(
            $config['host'] ?? null,
            $config['username'] ?? null,
            $config['password'] ?? null,
            $config['dbname'] ?? '',
            $config['port'] ?? '3306',
            $config['socket'] ?? null
        );

        // unable to connect, throw eexception.
        if (false === $GLOBALS['._pirogue.database_collection.connections'][$name]) {
            trigger_error(sprintf('Unable to open database connection "%s"', $name));
        }
    }

    // return connection.
    return $GLOBALS['._pirogue.database_collection.connections'][$name];
}
