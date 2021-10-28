<?php

/**
 * Assist in testing user_session library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

 /**
  * Label to use for testing site notices.
  * @var string  _PIROGUE_TESTING_SITE_NOTICES_LABEL
  */
define('_PIROGUE_TESTING_SITE_NOTICES_LABEL', '._pirogue-testing.site_notices.label');

/**
  * Collection of testing site notices.
  * @var array $GLOBALS['.pirogue-testing.session_notices.notices']
  */
$GLOBALS['.pirogue-testing.session_notices.notices'] = [
    ['error', 'test error message.'],
    ['info', 'test info message.'],
    ['warning', 'test warning message.'],
];
