<?php

/**
 * Testing html_view_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\html_view_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'html_view.php']));

pirogue_test_execute("html_view_init(): check pattern", function () {
    $format = implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view', '%s.phtml']);
    html_view_init($format);
    return $format == $GLOBALS['._pirogue.html_view.pattern']
        ? ''
        : 'invalid view pattern.';
});
