<?php

    function site_user_fetch_by_id(mysqli $database_connection, int $id ): ?array {
        return site_user_fetch($database_connection, 'id', $id);
    }

    function site_user_fetch(mysqli $database_connection, string $key, string $value): ?array {
        $sql_query = sprintf(
            "SELECT id, username, email, password FROM users WHERE %s='%s' LIMIT 1",
            $key,
            mysqli_real_escape_string($database_connection, $value)
        );
        $sql_result = mysqli_query($database_connection, $sql_query);
        if ( false != $sql_result ) {
            $user_data = mysqli_fetch_assoc($sql_result);
            mysqli_free_result($sql_result);
        } else {
            $user_data = null;
        }
        return $user_data;
    }

    function site_user_list(mysqli $database_connection): array {
        $sql_result = mysqli_query($database_connection, 'SELECT id, username, email, password FROM users ORDER BY id ASC');
        $users = [];
        while ( $user_data = mysqli_fetch_assoc($sql_result) ) {
            array_push($users, $user_data);
        }
        mysqli_free_result($sql_result);
        return $users;
    }
