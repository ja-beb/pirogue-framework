<?php

/**
 * Database connections for a MySQL backend.
 * Handles the opening, storing, retrieving and closing of database connections by translating requested name into config file.
 * php version 8.0.0
 * 
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @category
 * @package
 * @license
 * @version
 * @link
 */

/**
 * Config folder's path.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.database_collection.config_path']
 */
$GLOBALS['._pirogue.database_collection.config_path'] = null;

/**
 * Default database connection label - returned if no value is passed to the database_collection_get function.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.database_collection.default']
 */
$GLOBALS['._pirogue.database_collection.default'] = '';

/**
 * Collection of open database connections.
 *
 * @internal
 * @var array $GLOBALS['._pirogue.database_collection.connections']
 */
$GLOBALS['._pirogue.database_collection.connections'] = [];

/**
 * Initialize database collection library. This function will also register the database collection's destruct function as a shutdown function.
 *
 * @see register_shutdown_function
 * @param string $config_path
 *            Configuration path folder - where the database connection settings files can be found.
 * @param string $default
 *            The name of the default database connection, used when there is no value passed to the get function.
 */
function __database_collection(string $config_path, string $default): void
{
    $GLOBALS['._pirogue.database_collection.connections'] = [];
    $GLOBALS['._pirogue.database_collection.config_path'] = $config_path;
    $GLOBALS['._pirogue.database_collection.default'] = $default;    
    register_shutdown_function(__database_collection_destruct);
}

/**
 * Deconstruct function for the database collection. Responsible for clossing all mysqli connections.
 */
function __database_collection_destruct() : void
{
    foreach ($GLOBALS['._pirogue.database_collection.connections'] as $connection) {
        if ('mysqli' == get_class($connection)) {
            mysqli_close($connection);
        }
    }
    $GLOBALS['._pirogue.database_collection.connections'] = [];
}

/**
 * Open database connection.
 *
 * Fetches connection based on name by translating nane to a config file ("{$config_path}\mysqli-{$name}.ini")
 * which contain the attributes for 'name' and 'options' as defined by the sqlsrv_connect() function.
 *
 * @param string $name
 * @return \Mysqli item
 */
function database_collection_get(string $name = null): Mysqli
{
    $name = (null == $name) ? $GLOBALS['._pirogue.database_collection.default'] : $name;
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database_collection.connections'])) {
        $file_include = sprintf('%s/mysqli-%s.ini', $GLOBALS['._pirogue.database_collection.config_path'], $name);

        if (false == file_exists($file_include)) {
            throw new ErrorException("Unable to find database connection '{$name}' => {$file_include}.");
        }
        $config = parse_ini_file($file_include);

        $GLOBALS['._pirogue.database_collection.connections'][$name] = mysqli_connect($config['host'] ?? null, $config['username'] ?? null, $config['password'] ?? null, $config['dbname'] ?? '', $config['port'] ?? '3306', $config['socket'] ?? null);

        if (false === $GLOBALS['._pirogue.database_collection.connections'][$name]) {
            throw new ErrorException("Unable to open database connection '{$name}'.");
        }
    }
    return $GLOBALS['._pirogue.database_collection.connections'][$name];
}