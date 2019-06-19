<?php
/**
 * Primary dispatcher library.
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */
namespace pirogue;


/**
 * Html view base folder.
 *
 * @var string $GLOBALS['._pirogue.view.path']
 */
$GLOBALS['._pirogue.view.path'] = '';

/**
 * initialize view folder.
 * @param string $path
 */
function __view_html(string $path){
    $GLOBALS['._pirogue.view.path'] = $path;
}

/**
 * Initialize base html view variables.
 */
function _view_html_clear(string $id, array $options){
    $GLOBALS['.pirogue.html.head'] = $options['html.head'] ?? '';
    $GLOBALS['.pirogue.html.head.title'] = $options['html.head.title'] ?? '';
    $GLOBALS['.pirogue.html.body.id'] = $id;
    $GLOBALS['.pirogue.html.body.class'] = $options['html.body.class'] ?? '';
    $GLOBALS['.pirogue.html.css.files'] = $options['html.css.files'] ?? [];
    $GLOBALS['.pirogue.html.css.inline'] = $options['html.css.inline'] ?? '';
    $GLOBALS['.pirogue.html.script.inline'] = $options['html.script.inline'] ?? '';
    $GLOBALS['.pirogue.html.script.files'] = $options['html.script.files'] ?? [];
}

/**
 * Get html view file.
 * @param string $file HTML view path relative to view base.
 * @return string
 */
function _view_html_get_path(string $file): string{
    $_view_file = "{$GLOBALS['._pirogue.view.path']}\\{$file}";
    return file_exists($_view_file) ? $_view_file : '';
}

