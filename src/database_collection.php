<?php

/**
 * Database connections for a MySQL backend.
 * Handles the opening, storing, retrieving and closing of database connections by translating
 * requested name into config file.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 * Config folder's path.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.database_collection.config_path']
 */
$GLOBALS['._pirogue.database_collection.config_path'] = null;

/**
 * Default database connection label - returned if no value is passed to the database_collection_get function.
 *
 * @internal used by library only.
 * @var string $GLOBALS['._pirogue.database_collection.default']
 */
$GLOBALS['._pirogue.database_collection.default'] = '';

/**
 * Collection of open database connections.
 *
 * @internal used by library only.
 * @var array $GLOBALS['._pirogue.database_collection.connections']
 */
$GLOBALS['._pirogue.database_collection.connections'] = [];

/**
 * Initialize database collection library. This function will also register the database collection's destruct
 * function as a shutdown function.
 *
 * @throws InvalidArgumentException if $config_path directory does not exist.
 * @throws ErrorException default database does not exist.
 * @uses _pirogue_database_collection_get_config()
 * @uses $GLOBALS['._pirogue.database_collection.config_path']
 * @uses $GLOBALS['._pirogue.database_collection.default']
 * @uses $GLOBALS['._pirogue.database_collection.connections']
 * @param string $config_path the path to the config directory that stores the database connection settings.
 * @param string $default the name of the default database.
 */
function pirogue_database_collection_init(string $config_path, string $default): void
{
    if (!is_dir($config_path)) {
        throw new InvalidArgumentException(sprintf('Directory does not exist: "%s"', $config_path));
    }
    $GLOBALS['._pirogue.database_collection.config_path'] = $config_path;


    if (null == _pirogue_database_collection_get_config($default)) {
        throw new ErrorException("Unable to find database connection '{$default}' => {$file_include}.");
    }
    $GLOBALS['._pirogue.database_collection.default'] = $default;
    $GLOBALS['._pirogue.database_collection.connections'] = [];

    // register destruct function.
    register_shutdown_function('_pirogue_database_collection_destruct');
}

/**
 * Close and dealocate all registered mysqli connections.
 *
 * @internal used by library only.
 * @uses $GLOBALS['._pirogue.database_collection.connections']
 */
function _pirogue_database_collection_destruct(): void
{
    foreach ($GLOBALS['._pirogue.database_collection.connections'] as $connection) {
        if ('mysqli' == get_class($connection)) {
            mysqli_close($connection);
        }
    }
    $GLOBALS['._pirogue.database_collection.connections'] = [];
}

/**
 * Translate name to config file location.
 *
 * @uses $GLOBALS['._pirogue.database_collection.default']
 * @param string $name the name of database connection to open. Corresponds to config file mysql-{$name}.ini.
 * @return ?string the path to config file if exist otherwise null.
 */
function _pirogue_database_collection_get_config(string $name): ?string
{
    $file_include = sprintf('%s/mysqli-%s.ini', $GLOBALS['._pirogue.database_collection.config_path'], $name);
    return file_exists($file_include) ? $file_include : null;
}

/**
 * Open database connection.
 * Fetches connection based on name by translating nane to a config file ("{$config_path}\mysqli-{$name}.ini")
 * which contain the attributes for 'name' and 'options' as defined by the sqlsrv_connect() function.
 *
 * @throws ErrorException if database not found or unable to open requested database.
 * @uses _pirogue_database_collection_get_config()
 * @uses $GLOBALS['._pirogue.database_collection.connections']
 * @uses $GLOBALS['._pirogue.database_collection.default']
 * @param string $name
 * @return mysqli resource item.
 */
function pirogue_database_collection_get(?string $name = null): mysqli
{
    $name = null == $name ? $GLOBALS['._pirogue.database_collection.default'] : $name;
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database_collection.connections'])) {
        $file_include = _pirogue_database_collection_get_config($name);

        if (null == $file_include) {
            throw new ErrorException("Unable to find database connection '{$name}' => {$file_include}.");
        }
        $config = parse_ini_file($file_include);

        $GLOBALS['._pirogue.database_collection.connections'][$name] = mysqli_connect(
            $config['host'] ?? null,
            $config['username'] ?? null,
            $config['password'] ?? null,
            $config['dbname'] ?? '',
            $config['port'] ?? '3306',
            $config['socket'] ?? null
        );

        if (false === $GLOBALS['._pirogue.database_collection.connections'][$name]) {
            throw new ErrorException("Unable to open database connection '{$name}'.");
        }
    }
    return $GLOBALS['._pirogue.database_collection.connections'][$name];
}
