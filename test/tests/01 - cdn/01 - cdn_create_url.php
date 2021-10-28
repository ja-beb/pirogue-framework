<?php

/**
 * Testing cdn_url_create()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

use function pirogue\cdn_url_create;
use function pirogue\cdn_init;

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

  pirogue_test_execute("cdn_url_create(): create valid url", function () {
    cdn_init([$GLOBALS['._pirogue-testing.cdn.list'][0]]);
    return $GLOBALS['._pirogue-testing.cdn.list'][0] == cdn_url_create('', [])
        ? ''
        : 'Invalid url returned.';
  });

  pirogue_test_execute("cdn_url_create(): empty cdn list", function () {
    try {
        cdn_init([]);
        $GLOBALS['._pirogue-testing.cdn.list'][0] == cdn_url_create('', []);
        return 'Created url form empty list of servers.';
    } catch (\LogicException) {
        return '';
    }
  });

  pirogue_test_execute("cdn_url_create(): create valid url with params", function () {
    cdn_init([$GLOBALS['._pirogue-testing.cdn.list'][0]]);
    $url = sprintf('%s/path/to/resource.css?id=1', $GLOBALS['._pirogue-testing.cdn.list'][0]);
    return $url == cdn_url_create('path/to/resource.css', ['id' => 1])
        ? ''
        : 'Invalid url returned.';
  });

  pirogue_test_execute("cdn_url_create(): verify \$GLOBALS['._pirogue.cdn.current_index'] starts at 0.", function () {
    cdn_init($GLOBALS['._pirogue-testing.cdn.list']);
    return 0 == $GLOBALS['._pirogue.cdn.current_index'] ? '' : 'Invalid start index.';
  });

  pirogue_test_execute("cdn_url_create(): verify \$GLOBALS['._pirogue.cdn.current_index'] increments.", function () {
    cdn_init($GLOBALS['._pirogue-testing.cdn.list']);
    $count = count($GLOBALS['._pirogue-testing.cdn.list']);
    for ($i = 0; $i < $count; $i++) {
        cdn_url_create('path/to/resource.css', ['id' => 1]);
        if (($i + 1) % $count != $GLOBALS['._pirogue.cdn.current_index']) {
            return sprintf('Invalid index increment (%d,%d).', $i + 1, $GLOBALS['._pirogue.cdn.current_index']);
        }
    }
    return '';
  });
