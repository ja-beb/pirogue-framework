<?php

/**
 * Database connections for a MySQL backend. 
 * 
 * Handles the opening, storing, retrieving and closing of database connections by translating requested name into config file.
 * 
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 * Config folder's path.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.database_collection.config_path']
 */
$GLOBALS['._pirogue.database_collection.config_path'] = null;

$GLOBALS['._pirogue.database_collection.default'] = '';

/**
 * Collection of open database connections.
 *
 * @internal
 * @var array $GLOBALS['._pirogue.database_collection.connections']
 */
$GLOBALS['._pirogue.database_collection.connections'] = [];

/**
 * Initialize database collection library.
 *
 * @param string $config_path
 *              Configuration path folder - where the database connection settings files can be found.
 * @param string $default 
 *              The name of the default database connection, used when there is no value passed to the get function.
 */
function database_collection_init(string $config_path, string $default): void
{
    $GLOBALS['._pirogue.database_collection.config_path'] = $config_path;
    $GLOBALS['._pirogue.database_collection.default'] = $default;

    register_shutdown_function(function () {
        foreach ($GLOBALS['._pirogue.database_collection.connections'] as $connection) {
            if ('mysqli' == get_class($_database)) {
                mysqli_close($connection);
            }
        }
        $GLOBALS['._pirogue.database_collection.connections'] = [];
    });
}

/**
 * Open database connection.
 *
 * Fetches connection based on name by translating nane to a config file ("{$config_path}\mysqli-{$name}.ini")
 * which contain the attributes for 'name' and 'options' as defined by the sqlsrv_connect() function.
 *
 * @param string $name
 * @return mysqli item
 */
function database_collection_get(string $name = null): ?mysqli
{
    $name = (null == $name) ? $GLOBALS['._pirogue.database_collection.default'] : $name;
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database_collection.connections'])) {
        $file_include = sprintf('%s\sqlsrv-%s.ini', $GLOBALS['._pirogue.database_collection.config_path'], $name);

        if (false == file_exists($file_include)) {
            throw new ErrorException("Unable to find database connection '{$name}'.");
        }

        $config = parse_ini_file($file_include);
        $GLOBALS['._pirogue.database_collection.connections'][$name] = mysqli_connect(
            $config['host'] ?? null
                , $config['username'] ?? null
                , $config['password'] ?? null
                , $config['dbname'] ?? ''
                , $config['port'] ?? '3306'
                , $config['socket'] ?? null
        );

        if (false === $GLOBALS['._pirogue.database_collection.connections'][$name]) {
            throw new ErrorException("Unable to open database connection '{$name}'.");
        }
    }
    return $GLOBALS['._pirogue.database_collection.connections'][$name];
}