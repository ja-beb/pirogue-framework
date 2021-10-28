<?php

/**
 * library for working with html views.
 *
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * file path pattern for the html view file.
 *
 * @var string $GLOBALS['._pirogue.html_view.pattern']
 */
$GLOBALS['._pirogue.html_view.pattern'] = '';

/**
 * initialize view
 *
 * @uses $GLOBALS['._pirogue.html_view.pattern']
 * @param string $pattern
 * @return void
 */
function html_view_init(string $pattern)
{
    $GLOBALS['._pirogue.html_view.pattern'] = $pattern;
}

/**
 * create html view array.
 *
 * @param string $title title of page.
 * @param string $page_id id of page.
 * @param string $page_class class of page.
 * @return array array to hold html view data.
 */
function html_view_create(string $title = '', string $id = '', string $class = '', array $path = []): array
{
    return [
        'head' => ['title' => $title, 'content' => ''],
        'css' => ['files' => [], 'inline' => ''],
        'script' => ['files' => [], 'inline' => ''],
        'body' => [
            'id' => $id,
            'class' => $class,
            'path' => $path,
            'content' => '',
        ]
    ];
}

/**
 * load view file.
 *
 * @uses $GLOBALS['._pirogue.html_view.pattern']
 * @param string $view view to load.
 * @param array $view_data data to pass to view.
 * @param array $page_data page data to use in building this page. Returns data from view.
 * @return array page data.
 */
function html_view_load(string $view, array $view_data = [], array $html_view = null): array
{
    $view_file = sprintf($GLOBALS['._pirogue.html_view.pattern'], $view);
    if (!file_exists($view_file)) {
        trigger_error(sprintf('requested view file "%s" does not exists.', $view));
        return [];
    }

    if (null == $html_view) {
        $html_view = html_view_create();
    }

    ob_start();
    require $view_file;
    $html_view['body']['content'] = ob_get_clean();
    return $html_view;
}
