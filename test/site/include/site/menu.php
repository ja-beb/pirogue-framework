<?php


    function site_menu_create(string $label, string $path, array $request = [], ?string $title = ''):array {
        return [
            'title' => $title,
            'label' => $label,
            'path' => $path,
            'request' => $request
        ];
    }
