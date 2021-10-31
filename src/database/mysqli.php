<?php

/**
 * handle MySQL database connections.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\database\mysqli;

use mysqli;

/**
 * a sprintf format string of the connection ini file's path.
 * @internal
 * @var string $GLOBALS['._pirogue.database.mysqli.path_format']
 */
$GLOBALS['._pirogue.database.mysqli.path_format'] = null;

/**
 * default database connection that used.
 * @internal
 * @var string $GLOBALS['._pirogue.database.mysqli.default']
 */
$GLOBALS['._pirogue.database.mysqli.default'] = '';

/**
 * a list of the registered database connections.
 * @internal
 * @var array $GLOBALS['._pirogue.database.mysqli.connections']
 */
$GLOBALS['._pirogue.database.mysqli.connections'] = [];


/**
 * initialize library.
 * @internal
 * @uses $GLOBALS['._pirogue.database.mysqli.path_format']
 * @uses $GLOBALS['._pirogue.database.mysqli.default']
 * @uses $GLOBALS['._pirogue.database.mysqli.connections']
 * @param string $path_format a sprintf path_format used to find the desired database config file based on inputed name.
 * @param string $default the name of the default database.
 * @return void
 */
function _init(string $path_format, string $default): void
{
    $GLOBALS['._pirogue.database.mysqli.path_format'] = $path_format;
    $GLOBALS['._pirogue.database.mysqli.default'] = $default;
    $GLOBALS['._pirogue.database.mysqli.connections'] = [];
}

/**
 * deallocate library variables. Will close any open connections if they exist.
 * @internal
 * @uses _close()
 * @uses $GLOBALS['._pirogue.database.mysqli.path_format']
 * @uses $GLOBALS['._pirogue.database.mysqli.default']
 * @uses $GLOBALS['._pirogue.database.mysqli.connections']
 * @return void
 */
function _dispose(): void
{
    if (!empty($GLOBALS['._pirogue.database.mysqli.connections'])) {
        close_all();
    }

    unset(
        $GLOBALS['._pirogue.database.mysqli.default'],
        $GLOBALS['._pirogue.database.mysqli.path_format'],
        $GLOBALS['._pirogue.database.mysqli.connections'],
    );
}

/**
 * translates database name to the ini file's path.
 * @internal
 * @uses $GLOBALS['._pirogue.database.mysqli.path_format']
 * @param string $name name of connection to load configuration for.
 * @return ?array returns config file or null if not found.
 */
function _config(string $name): ?array
{
    $connection = false;
    $file = sprintf($GLOBALS['._pirogue.database.mysqli.path_format'], $name);
    return file_exists($file) ? parse_ini_file($file) : null;
}

/**
 * open requested connection. translates name to the mysqli ini file's path and loads using data.
 * @internal
 * @param string $hostname database's hostname or address.
 * @param string $username the MySQL user name.
 * @param ?string $password the password to use for this connection.
 * @param ?string $database the name of the database to connect to.
 * @param int $port the port number to attempt to connect to the MySQL server.
 * @param int $socket the socket or named pipe to used to connect.
 * @return ?mysqli return null if not found or does not connect.
 */
function _open(string $hostname, string $username, ?string $password = null, ?string $database = null, int $port = 3306, int $socket = null): ?mysqli
{
    $connection = mysqli_connect(
        hostname:$hostname,
        username:$username,
        password:$password,
        database:$database,
        port:$port,
        socket:$socket
    );
    return false == $connection ? null : $connection;
}

/**
 * helper function that fetches an unregistered database connection.
 * @param string $name
 * @return mysqli|null
 */
function _get(string $name): ?mysqli
{
    $config = _config($name);
    if (null == $config) {
        return null;
    } else {
        $connection = _open(
            hostname: $config['hostname'],
            username: $config['username'],
            password: $config['password'] ?? null,
            database: $config['database'] ?? null,
            port: $config['port'] ?? 3306,
            socket: $config['socket'] ?? null,
        );
        return false == $connection ? null : $connection;
    }
}

function close_all(): void
{
    foreach (($GLOBALS['._pirogue.database.mysqli.connections'] ?? []) as $connection) {
        if (null != $connection && 'mysqli' == get_class($connection)) {
            mysqli_close($connection);
        }
    }
    $GLOBALS['._pirogue.database.mysqli.connections'] = [];
}

/**
 * get database connection.
 * @throws error error tiggered if unable to connect or not registered.
 * @uses $GLOBALS['._pirogue.database.mysqli.connections']
 * @uses $GLOBALS['._pirogue.database.mysqli.default']
 * @param string $name name of database to connect. will return default if null.
 * @return mysqli resource item.
 */
function get(?string $name = null): mysqli
{
    $name = null == $name ? $GLOBALS['._pirogue.database.mysqli.default'] : $name;
    if (false == array_key_exists($name, $GLOBALS['._pirogue.database.mysqli.connections'])) {
        $GLOBALS['._pirogue.database.mysqli.connections'][$name] = _get($name);
        if (null == $GLOBALS['._pirogue.database.mysqli.connections'][$name]) {
            trigger_error(sprintf('unable to connect to database "%s"', $name));
        }
    }
    return $GLOBALS['._pirogue.database.mysqli.connections'][$name];
}
