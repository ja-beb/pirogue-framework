<?php

    function site_user_fetch(mysqli $database_connection, int $id ): ?array {
        $sql_result = mysqli_query($database_connection, sprintf('SELECT id, username, email, password FROM users WHERE id=%d LIMIT 1', $id));
        $user_data = mysqli_fetch_assoc($sql_result);
        return $user_data;
    }