<?php

/**
 * Database connection functionality. 
 * 
 * Functions are not multi-thread safe - executing database_collection_open() and _database_collection_close() can cause race conditions.  
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace sprout;

use ErrorException;

/**
 * Base config path.
 *
 * @internal
 * @var string $GLOBALS['._sprout.database_collection.config_path']
 */
$GLOBALS['._sprout.database_collection.config_path'] = null;

/**
 * Collection of open database connections.
 *
 * @internal
 * @var array $GLOBALS['._sprout.database_collection.connections']
 */  
$GLOBALS['._sprout.database_collection.connections'] = [];

/**
 * Setup database collection library.
 *
 * @param string $config_path
 *            Configuration path folder - where the database connection settings can be found.
 */
function __database_collection(string $config_path)
{
    register_shutdown_function('sprout\_database_collection_close');
    $GLOBALS['._sprout.database_collection.config_path'] = $config_path;
}

/**
 * Open database connection.
 * 
 * Fetches connection information based on name by translating to a config file {$config_path}\{$name}.ini
 * For case sensitive impementations this function translate inputed name varaible to lower case.
 *
 * @param string $name
 * @return resource
 */
function database_collection_open(string $name)
{
    $name = strtolower($name);
    if (false == array_key_exists($name, $GLOBALS['._sprout.database_collection.connections'])) {
        $file = sprintf('%s\sqlsrv-%s.ini', $GLOBALS['._sprout.database_collection.config_path'], $name);
        if (false == file_exists($file)) {
            throw new ErrorException("Unable to find database connection {$name}.");
        }
        $config = parse_ini_file($file, false);
        $GLOBALS['._sprout.database_collection.connections'][$name] = sqlsrv_connect($config['name'] ?? '', $config['options'] ?? []);

        if (false === $GLOBALS['._sprout.database_collection.connections'][$name]) {
            throw new ErrorException("Unable to open database connection {$name}.");
        }
    }
    return $GLOBALS['._sprout.database_collection.connections'][$name];
}

/**
 * Close all active database connections.
 * @internal
 */
function _database_collection_close()
{
    foreach ($GLOBALS['._sprout.database_collection.connections'] as $connection) {
        if (null != $connection && 'SQL Server Connection' == get_resource_type($connection)) {
            sqlsrv_close($connection);
        }
    }
    $GLOBALS['._sprout.database_collection.connections'] = [];
}