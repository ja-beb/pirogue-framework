<?php

/**
 * Database connection functionality. Functions are not multi-thread safe - executing database_collection_open() 
 * and _database_collection_close() can cause race conditions.  
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;

use ErrorException;

/**
 * @internal
 * @var string $GLOBALS['._pirogue.database_collection.config_path']
 */
$GLOBALS['._pirogue.database_collection.config_path'] = null;

/**
 * @internal
 * @var array $GLOBALS['._pirogue.database_collection.database_connections']
 */
$GLOBALS['._pirogue.database_collection.database_connections'] = [];

/**
 * Setup database collection library.
 * @param string $config_path Configuration path folder - where the database connection settings can be found.
 */
function __database_collection(string $config_path)
{
    register_shutdown_function('pirogue\_database_collection_close');
    $GLOBALS['._pirogue.database_collection.config_path'] = $config_path;
}

/**
 * Open database connection - fetches connection based on name by translating user inputed "databaseName" into
 * a config file {$config_path}\sqlsrv-{$name}.ini
 * @param string $name
 */
function database_collection_open(string $name)
{
    $name = strtolower($name);
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database_collection.database_connections'])) {
        $file = sprintf('%s\sqlsrv-%s.ini', $GLOBALS['._pirogue.database_collection.config_path'], $name);
        if (false == file_exists($file)) {
            throw new ErrorException("Unable to find database connection {$name}.");
        }
        $config = parse_ini_file($file, false);
        $GLOBALS['._pirogue.database_collection.database_connections'][$name] = sqlsrv_connect($config['name'] ?? '', $config['options'] ?? []);
        
        if (false === $GLOBALS['._pirogue.database_collection.database_connections'][$name] ){
            throw new ErrorException("Unable to open database connection {$name}.");
        }
    }
    return $GLOBALS['._pirogue.database_collection.database_connections'][$name];
}

/**
 * @internal
 * Close all active database connections (cleanup function.
 */
function _database_collection_close()
{
    foreach ($GLOBALS['._pirogue.database_collection.database_connections'] as $connection) {
        if (null != $connection && 'SQL Server Connection' == get_resource_type ( $connection )) {
            sqlsrv_close($connection);
        }
    }
    $GLOBALS['._pirogue.database_collection.database_connections'] = [];
}