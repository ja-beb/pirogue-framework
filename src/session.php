<?php

/**
 * session functions.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * name for the user session.
 * @internal
 * @var string $GLOBALS['._pirogue.session.name']
 */
$GLOBALS['._pirogue.session.name'] = '';

/**
 * initialize user session library.
 * @uses $GLOBALS['._pirogue.session.name']
 * @param string $name the name of this session.
 * @return void
 */
function _session_init(string $name): void
{
    $GLOBALS['._pirogue.session.name'] = $name;
}

/**
 * dispose of this library.
 * @internal
 * @uses $GLOBALS['._pirogue.session.user.label']
 * @return void
 */
function _session_dispose(): void
{
    unset($GLOBALS['._pirogue.session.name']);
}


//
// session start/end functions
//

/**
 * start new user session
 * @internal
 * @uses $GLOBALS['._pirogue.session.name']
 * @return void
 */
function _session_start(): void
{
    session_start([
        'name' => $GLOBALS['._pirogue.session.name']
    ]);
}

/**
 * end the current session.
 * @internal
 * @return bool success flag.
 */
function _session_end(): bool
{
    return session_write_close();
}
