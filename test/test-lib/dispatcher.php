<?php

/**
 * Assist in testing dispatcher library.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

/**
 * testing site uri.
 * @var string $GLOBALS['.pirogue-testing.dispatcher.address']
 */
$GLOBALS['.pirogue-testing.dispatcher.address'] = 'https://site.localhost.localdomain';

/**
 * testing site path.
 * @var string $GLOBALS['.pirogue-testing.dispatcher.request_path']
 */
$GLOBALS['.pirogue-testing.dispatcher.request_path'] = 'path.html';

/**
 * testing site data.
 * @var string $GLOBALS['.pirogue-testing.dispatcher.request_data']
 */
$GLOBALS['.pirogue-testing.dispatcher.request_data'] = ['id' => 1];
