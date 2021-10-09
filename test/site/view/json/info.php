<?php

    if ( empty($GLOBALS['.request_path']) ) {
        // List available components.
        $_api_endpoints = [];
        foreach (scandir(implode(DIRECTORY_SEPARATOR, [__DIR__, 'info'])) as $_file) {
            if (!is_dir($_file) && preg_match('/\.php$/', $_file)) {
                $_path = preg_replace('/\.php$/', '', $_file);
                $_api_endpoints[$_path] = $_uri = pirogue_dispatcher_create_url(sprintf('%s/%s.json', $GLOBALS['.request_page'], $_path), []);
            }
        }
        return $_api_endpoints;
    } else {
        // Load requsted child component.
        $_page = array_shift($GLOBALS['.request_path']);
        $_view = implode( DIRECTORY_SEPARATOR, [$GLOBALS['.request_page'], $_page]);
        $_view_file = _pirogue_view_get_path($_view);
        $_json_data = require $_view_file;
        return $_json_data;
    }