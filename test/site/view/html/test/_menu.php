<?php

    pirogue_import_load('site/menu');

    return [
        site_menu_create( label: 'Test Redirect', path: 'redirect.html' ),
        site_menu_create( label: 'Error 500', path: 'error-500.html' ),
        site_menu_create( label: 'Site Notices', path: 'site-notices.html' ),
    ];