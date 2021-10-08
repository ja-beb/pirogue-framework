<?php

    pirogue_import_load('site/menu');

    return [
        site_menu_create(
            label: 'Test Redirect',
            path: 'redirect.html'
        ),
    ];