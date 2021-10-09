<?php

    function _site_user_query(mysqli $database_connection, string $filter, string $order_by=''): array {
        $sql_result = mysqli_query($database_connection, "SELECT id, username, email, password FROM users {$filter} {$order_by}");
        if ( is_bool($sql_result) ){
            return [];
        }
        $users = [];
        while ( $data = mysqli_fetch_assoc($sql_result) ) {
            array_push($users, $data);
        }
        mysqli_free_result($sql_result);
        return $users;
    }

    function site_user_fetch_by_id(mysqli $database_connection, int $id ): ?array {
        $users = _site_user_query($database_connection, sprintf('WHERE id=%d', $id), 'LIMIT 1');
        return empty($users) ? null : current($users);
    }

    function site_user_fetch(mysqli $database_connection, string $key, string $value): ?array {
        $sql_filter = sprintf(
            "WHERE %s='%s'",
            $key,
            mysqli_real_escape_string($database_connection, $value)
        );
        $users = _site_user_query($database_connection, $sql_filter, 'LIMIT 1');
        return empty($users) ? null : current($users);
    }

    function site_user_list(mysqli $database_connection): array {
        return _site_user_query($database_connection, '');
    }
