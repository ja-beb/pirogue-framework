<?php

/**
 * Testing url_create()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\cdn\url_create;
use function pirogue\cdn\_init;
use function pirogue\cdn\_finalize;

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'cdn.php']));

/**
 * Sample cdn list.
 * @var array $GLOBALS['._pirogue-testing.cdn.list']
 */
$GLOBALS['._pirogue-testing.cdn.list'] = [
  'https://cdn00.localhost.localdomain',
  'https://cdn01.localhost.localdomain',
  'https://cdn02.localhost.localdomain',
  'https://cdn03.localhost.localdomain',
];

_init([$GLOBALS['._pirogue-testing.cdn.list'][0]]);
pirogue_test_execute("url_create(): create valid url", function () {
    return $GLOBALS['._pirogue-testing.cdn.list'][0] == url_create('', []) ? '' : 'Invalid url returned.';
});
_finalize();

_init([]);
pirogue_test_execute("url_create(): empty cdn list", function () {
    try {
        $GLOBALS['._pirogue-testing.cdn.list'][0] == url_create('', []);
        return 'Created url form empty list of servers.';
    } catch (\LogicException) {
        return '';
    } finally {
    }
});
_finalize();

_init([$GLOBALS['._pirogue-testing.cdn.list'][0]]);
pirogue_test_execute("cdn_url_create(): create valid url with params", function () {
    $url = sprintf('%s/path/to/resource.css?id=1', $GLOBALS['._pirogue-testing.cdn.list'][0]);
    return $url == url_create('path/to/resource.css', ['id' => 1]) ? '' : 'Invalid url returned.';
});
_finalize();

_init($GLOBALS['._pirogue-testing.cdn.list']);
pirogue_test_execute("cdn_url_create(): verify \$GLOBALS['._pirogue.cdn.current_index'] starts at 0.", function () {
    return 0 == $GLOBALS['._pirogue.cdn.current_index'] ? '' : 'Invalid start index.';
});
_finalize();

_init($GLOBALS['._pirogue-testing.cdn.list']);
pirogue_test_execute("cdn_url_create(): verify \$GLOBALS['._pirogue.cdn.current_index'] increments.", function () {
    $count = count($GLOBALS['._pirogue-testing.cdn.list']);
    for ($i = 0; $i < $count; $i++) {
        url_create('path/to/resource.css', ['id' => 1]);
        if (($i + 1) % $count != $GLOBALS['._pirogue.cdn.current_index']) {
            return sprintf('Invalid index increment (%d,%d).', $i + 1, $GLOBALS['._pirogue.cdn.current_index']);
        }
    }
    return '';
});
_finalize();
