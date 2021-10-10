<?php

/**
 * Assist in testing user_session library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

 // load test object.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'test', 'Tuple.php']);

 /**
  * Label to use for initializing the user_session library.
  * @var string _PIROGUE_TESTING_USER_SESSION_LABEL
  */
define('_PIROGUE_TESTING_USER_SESSION_LABEL', '._pirogue-testing.user_session.label');

/**
  * Sample user session data.
  * @var array $GLOBALS['._pirogue-testing.user_session.list']
  */
$GLOBALS['._pirogue-testing.user_session.list'] = [
    'int_val' => 3.14,
    'function results' => sqrt(9),
    '.function' => fn(string $msg) => "I display '{$msg}'",
    '!array' => [1. . .10],
    '@object' => new Pirogue\Test\Tuple('label', 'value'),
];

/**
  * Sample user data.
  * @var array $GLOBALS['._pirogue-testing.user_session.user']
  */
$GLOBALS['._pirogue-testing.user_session.user'] = [
    'id' => 1,
    '.username' => 'admin',
    '@display name' => 'Admin User',
];
