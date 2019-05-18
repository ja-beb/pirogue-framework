<?php

/**
 * Database connections for SQL Server. 
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
 *            Configuration path folder - where the database connection settings can be found.
 */
function __database_collection(string $config_path)
{
    $GLOBALS['._pirogue.database_collection.config_path'] = $config_path;
    register_shutdown_function(function () {
        foreach ($GLOBALS['._pirogue.database_collection.connections'] as $connection) {
            if (null != $connection && 'SQL Server Connection' == get_resource_type($connection)) {
                sqlsrv_close($connection);
            }
        }
        $GLOBALS['._pirogue.database_collection.connections'] = [];
    });
}

/**
 * Open database connection.
 *
 * Fetches connection based on name by translating nane to a config file ("{$config_path}\sqlserver-{$name}.ini")
 * which contain the attributes for 'name' and 'options' as defined by the sqlsrv_connect() function.
 *
 * @param string $name
 * @return resource
 */
function database_collection_get(string $name)
{
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database_collection.connections'])) {
        $file_include = sprintf('%s\sqlsrv-%s.ini', $GLOBALS['._pirogue.database_collection.config_path'], $name);
        
        if (false == file_exists($file_include)) {
            throw new ErrorException("Unable to find database connection '{$name}'.");
        }

        $config = parse_ini_file($file_include, true);
        $GLOBALS['._pirogue.database_collection.connections'][$name] = sqlsrv_connect($config['name'] ?? '', $config['options'] ?? []);
        if (false === $GLOBALS['._pirogue.database_collection.connections'][$name]) {
            throw new ErrorException("Unable to open database connection '{$name}'.");
        }
    }
    return $GLOBALS['._pirogue.database_collection.connections'][$name];
}