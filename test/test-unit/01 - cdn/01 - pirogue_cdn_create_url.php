<?php

/**
 * Testing pirogue_cdn_create_url()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

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

  pirogue_test_execute("pirogue_cdn_create_url(): create valid url", function () {
    pirogue_cdn_init([$GLOBALS['._pirogue-testing.cdn.list'][0]]);
    return $GLOBALS['._pirogue-testing.cdn.list'][0] == pirogue_cdn_create_url('', [])
        ? ''
        : 'Invalid url returned.';
  });

  pirogue_test_execute("pirogue_cdn_create_url(): empty cdn list", function () {
    try {
        pirogue_cdn_init([]);
        $GLOBALS['._pirogue-testing.cdn.list'][0] == pirogue_cdn_create_url('', []);
        return 'Created url form empty list of servers.';
    } catch (LogicException) {
        return '';
    }
  });

  pirogue_test_execute("pirogue_cdn_create_url(): create valid url with params", function () {
    pirogue_cdn_init([$GLOBALS['._pirogue-testing.cdn.list'][0]]);
    $url = sprintf('%s/path/to/resource.css?id=1', $GLOBALS['._pirogue-testing.cdn.list'][0]);
    return $url == pirogue_cdn_create_url('path/to/resource.css', ['id' => 1])
        ? ''
        : 'Invalid url returned.';
  });

  pirogue_test_execute("pirogue_cdn_create_url(): verify \$GLOBALS['._pirogue.cdn.current_index'] starts at 0.", function () {
    pirogue_cdn_init($GLOBALS['._pirogue-testing.cdn.list']);
    return 0 == $GLOBALS['._pirogue.cdn.current_index'] ? '' : 'Invalid start index.';
  });

  pirogue_test_execute("pirogue_cdn_create_url(): verify \$GLOBALS['._pirogue.cdn.current_index'] increments.", function () {
    pirogue_cdn_init($GLOBALS['._pirogue-testing.cdn.list']);
    $count = count($GLOBALS['._pirogue-testing.cdn.list']);
    for ($i = 0; $i < $count; $i++) {
        pirogue_cdn_create_url('path/to/resource.css', ['id' => 1]);
        if (($i + 1) % $count != $GLOBALS['._pirogue.cdn.current_index']) {
            return sprintf('Invalid index increment (%d,%d).', $i + 1, $GLOBALS['._pirogue.cdn.current_index']);
        }
    }
    return '';
  });
