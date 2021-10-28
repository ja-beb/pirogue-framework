<?php

/**
 * Testing html_view_create()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\html_view_create;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'html_view.php']));

pirogue_test_execute("html_view_create(): check return value", function () {
    $title = 'my title';
    $id = 'my id';
    $class = 'my class';
    $path = 'my/path';

    $html_view = html_view_create(title: $title, id: $id, class: $class, path: explode('/', $path));

    if ($html_view['head']['title'] != $title) {
        return 'title not properly updated . ';
    }

    if ($html_view['body']['id'] != $id) {
        return 'id not properly updated . ';
    }

    if ($html_view['body']['class'] != $class) {
        return 'class not properly updated . ';
    }

    if (implode('/', $html_view['body']['path']) != $path) {
        return 'path not properly updated . ';
    }

    return '';
});
