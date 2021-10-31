<?php

/**
 * loader for html view files.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\view\html;

/**
 * sprintf pattern for the view's file path.
 * @internal
 * @var string $GLOBALS['._pirogue.view.html.path_pattern']
 */
$GLOBALS['._pirogue.view.html.path_pattern'] = '';

/**
 * initialize view
 * @internal
 * @uses $GLOBALS['._pirogue.view.html.path_pattern']
 * @param string $path_pattern the pattern used to build view file paths.
 * @return void
 */
function _init(string $path_pattern): void
{
    $GLOBALS['._pirogue.view.html.path_pattern'] = $path_pattern;
}

/**
 * clean up library variable state.
 * @internal
 * @uses $GLOBALS['._pirogue.view.html.path_pattern']
 * @return void
 */
function _dispose(): void
{
    unset(
        $GLOBALS['._pirogue.view.html.path_pattern'],
    );
}

/**
 * load view file.
 * @throws error tirggers an derror if the view file is not found.
 * @uses $GLOBALS['._pirogue.view.html.path_pattern']
 * @param string $view view to load.
 * @param array $view_data data to pass to view.
 * @return string view file's content.
 */
function load(string $view, array $view_data = []): string
{
    $buffer = '';
    $view_file = sprintf($GLOBALS['._pirogue.view.html.path_pattern'], $view);
    if (file_exists($view_file)) {
        ob_start();
        require $view_file;
        $buffer = ob_get_clean();
    } else {
        trigger_error(sprintf('requested view file "%s" does not exists.', $view));
    }
    return $buffer;
}
