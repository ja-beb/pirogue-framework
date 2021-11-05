<?php

/**
 * loader for json views.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\view;

/**
 * sprintf pattern for the view's file path.
 * @internal
 * @var string $GLOBALS['._pirogue.view.json.path_pattern']
 */
$GLOBALS['._pirogue.view.json.path_pattern'] = '';

/**
 * initialize view
 * @internal
 * @uses $GLOBALS['._pirogue.view.json.path_pattern']
 * @param string $path_pattern the pattern used to build view file paths.
 * @return void
 */
function _json_init(string $path_pattern): void
{
    $GLOBALS['._pirogue.view.json.path_pattern'] = $path_pattern;
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.view.json.path_pattern']
 * @return void
 */
function _json_dispose(): void
{
    unset($GLOBALS['._pirogue.view.json.path_pattern']);
}

/**
 * load view file.
 * @throws error will trigger an error file not found.
 * @uses $GLOBALS['._pirogue.view.json.path_pattern']
 * @param string $view view to load.
 * @param array $view_data data to pass to view.
 * @return mixed view file's contents.
 */
function json_load(string $view, array $view_data = []): mixed
{
    $view_file = sprintf($GLOBALS['._pirogue.view.json.path_pattern'], $view);
    if (file_exists($view_file)) {
        return require $view_file;
    } else {
        trigger_error(sprintf('requested view file "%s" does not exists.', $view));
        return [];
    }
}
