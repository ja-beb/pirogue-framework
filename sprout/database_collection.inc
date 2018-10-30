<?php
namespace sprout;

use ErrorException;

/**
 *
 * @var string $GLOBALS['._database_config_path']
 */
$GLOBALS['._database_config_path'] = null;

/**
 * 
 * @var array $GLOBALS['._database_connections']
 */
$GLOBALS['._database_connections'] = [];

/**
 *
 * @param string $config_path
 */
function __database_collection(string $config_path)
{
    register_shutdown_function('sprout\_database_collection_close');
    $GLOBALS['._database_config_path'] = $config_path;
}

/**
 *
 * @param string $name
 */
function database_collection_open(string $name)
{
    $name = strtolower($name);
    if (false == array_key_exists($name, $GLOBALS['._database_connections'])) {
        $file = sprintf('%s\sqlsrv-%s.ini', $GLOBALS['._database_config_path'], $name);
        if (false == file_exists($file)) {
            throw new ErrorException("Unable to find database connection {$name}.");
        }
        $config = parse_ini_file($file, false);
        $GLOBALS['._database_config_path'][$name] = sqlsrv_connect($config['name'] ?? '', $config['options'] ?? []);
    }
    return $GLOBALS['._database_connections'][$name];
}

/**
 * Close all active database connections.
 */
function _database_collection_close()
{
    foreach ($GLOBALS['._database_connections'] as $connection) {
        if ( $connection ){
            sqlsrv_close($connection);
        }
    }
    $GLOBALS['._database_connections'] = [];
}