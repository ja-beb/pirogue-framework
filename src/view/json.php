<?php

/**
 * library for working with json views.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\view\json;

/**
 * file path pattern for the json view file.
 * @internal
 * @var string $GLOBALS['._pirogue.view.json.path_pattern']
 */
$GLOBALS['._pirogue.view.json.path_pattern'] = '';

/**
 * initialize view
 * @internal
 * @uses $GLOBALS['._pirogue.view.json.path_pattern']
 * @param string $path_pattern the pattern used to build view file paths.
 * @param array $view_fragment view fragement to return.
 * @return void
 */
function _init(string $path_pattern): void
{
    $GLOBALS['._pirogue.view.json.path_pattern'] = $path_pattern;
}

/**
 * clean up library before exit.
 * @internal
 * @uses $GLOBALS['._pirogue.view.json.path_pattern']
 * @return void
 */
function _dispose(): void
{
    unset(
        $GLOBALS['._pirogue.view.json.path_pattern'],
    );
}

/**
 * load view file.
 * @throws error file not found.
 * @uses $GLOBALS['._pirogue.view.json.path_pattern']
 * @param string $view view to load.
 * @param array $view_data data to pass to view.
 * @param array $page_data page data to use in building this page. Returns data from view.
 * @return mixed controller data.
 */
function load(string $view, array $view_data = []): mixed
{
    $view_file = sprintf($GLOBALS['._pirogue.view.json.path_pattern'], $view);
    if (!file_exists($view_file)) {
        trigger_error(sprintf('requested view file "%s" does not exists.', $view));
        return [];
    }

    // load view and return output as body content.
    return require $view_file;
}
