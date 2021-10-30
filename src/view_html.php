<?php

/**
 * library for working with html views.
 *
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\view_html;

/**
 * file path pattern for the html view file.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.view_html.pattern']
 */
$GLOBALS['._pirogue.view_html.pattern'] = '';

/**
 * initialize view
 * @internal
 * @uses $GLOBALS['._pirogue.view_html.pattern']
 * @param string $pattern the pattern used to build view file paths.
 * @return void
 */
function _init(string $pattern): void
{
    $GLOBALS['._pirogue.view_html.pattern'] = $pattern;
}

/**
 * clean up library before exit.
 * @internal
 * @uses $GLOBALS['._pirogue.view_html.pattern']
 *
 * @return void
 */
function _dispose(): void
{
    unset($GLOBALS['._pirogue.view_html.pattern']);
}
/**
 * create html view array.
 *
 * @param string $title title of page.
 * @param string $page_id id of page.
 * @param string $page_class class of page.
 * @return array array to hold html view data.
 */
function create(string $title = '', string $id = '', string $class = '', array $path = []): array
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
 * @uses $GLOBALS['._pirogue.view_html.pattern']
 * @param string $view view to load.
 * @param array $view_data data to pass to view.
 * @param array $page_data page data to use in building this page. Returns data from view.
 * @return array page data.
 */
function load(string $view, array $view_data = [], array $view_html = null): array
{
    $view_file = sprintf($GLOBALS['._pirogue.view_html.pattern'], $view);
    if (!file_exists($view_file)) {
        trigger_error(sprintf('requested view file "%s" does not exists.', $view));
        return [];
    }

    // initialize html view if not provided.
    $view_html = null == $view_html ? create() : $view_html;

    // load view and return output as body content.
    ob_start();
    require $view_file;
    $view_html['body']['content'] = ob_get_clean();
    return $view_html;
}
