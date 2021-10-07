<?php

/**
 * Initialize php template.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

function site_html_create(
        ?string $html_title = null,
        ?string $page_title = null,
        ?string $page_id = null,
        ?string $page_class = null
    ): void 
{
    $GLOBALS['.html.head'] = '';
    $GLOBALS['.html.head.title'] = $html_title;
    $GLOBALS['.html.css.files'] = [];
    $GLOBALS['.html.css.inline'] = '';
    $GLOBALS['.html.script.inline'] = '';
    $GLOBALS['.html.script.files'] = [];
    $GLOBALS['.html.body.class'] = $page_class;
    $GLOBALS['.html.body.id'] = $page_id;
    $GLOBALS['.html.body.title'] = $page_title;
    $GLOBALS['.html.body.content'] = '';
}

