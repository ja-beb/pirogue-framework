<?php
    /*
     * Display user information. if user identifier is passed use specific user else all users.
     */
    function _get_user_info(mysqli $database_connection, string $key='', string $value=''): ?array {
        $sql_filter = match($key) {
            '' => '',
            'id' => sprintf('WHERE %s=%d', $key, $value),
            'email', 'username' => sprintf("WHERE %s='%s'", $key, mysqli_real_escape_string($database_connection, $value)),
        };

        $sql_query = "SELECT id, username, email FROM users {$sql_filter} ORDER BY id ASC";
        $sql_result = mysqli_query($database_connection, $sql_query);
        $users = [];
        while ( $sql_data = mysqli_fetch_assoc($sql_result) ) {
            array_push($users, $sql_data);
        }
        mysqli_free_result($sql_result);
        return 1 == count($users) ? $users[0] : $users;
    }

    $_database_connection = pirogue_database_collection_get();
    $_page = array_shift($GLOBALS['.request_path']);

    if (empty($GLOBALS['.request_path'])) {
        return _get_user_info($_database_connection);
    } elseif (intval($_page) == $_page){
            return _get_user_info($_database_connection, 'id', intval($_page));
    } else {
        $_key = match(strtolower($_page)){
            'email' => 'email',
            'id' => 'id',
            'username' => 'username',
            default => '',
        };
        return _get_user_info($_database_connection, $_key, array_shift($GLOBALS['.request_path']));
    }