<?php

/**
 * Testing cdn_init()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

 use function pirogue\cdn_init;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'cdn.php']));

pirogue_test_execute("cdn_init(): \$GLOBALS['._pirogue.cdn.address_list']", function () {
    $list = ['https://cdn.localhost.localdomain'];
    cdn_init($list);
    return $list == $GLOBALS['._pirogue.cdn.address_list']
        ? ''
        : "Variable \$GLOBALS['._pirogue.cdn.address_list'] not set properly";
});

pirogue_test_execute("cdn_init(): \$GLOBALS['._pirogue.cdn.current_index']", function () {
    cdn_init(['https://cdn.localhost.localdomain']);
    return 0 == $GLOBALS['._pirogue.cdn.current_index']
        ? ''
        : "Variable \$GLOBALS['._pirogue.cdn.address_list'] not set properly";
});
