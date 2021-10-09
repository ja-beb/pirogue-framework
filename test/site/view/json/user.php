<?php
    
    pirogue_import_load('site/users');

    $_database_connection = pirogue_database_collection_get();
    $_page = array_shift($GLOBALS['.request_path']);
    if ('' == $_page) {
        $_users = [];
        foreach ( site_user_list($_database_connection) as $_user ) {
            $_user['urls'] = [
                pirogue_dispatcher_create_url(sprintf('%s/%s.json', $GLOBALS['.request_page'], $_user['id']), []),
                pirogue_dispatcher_create_url(sprintf('%s/username/%s.json', $GLOBALS['.request_page'], $_user['username']), []),
                pirogue_dispatcher_create_url(sprintf('%s/id/%s.json', $GLOBALS['.request_page'], $_user['id']), [])
            ];
            array_push($_users, $_user);
        }
        return $_users;
    } elseif (intval($_page) == $_page){
        return site_user_fetch_by_id($_database_connection, intval($_page));
    } else {
        $_key = match(strtolower($_page)){
            'id' => 'id',
            'username' => 'username',
            default => '',
        };
        return site_user_fetch($_database_connection, $_key, array_shift($GLOBALS['.request_path']));
    }