<?php

/**
 * controller function.s
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\dispatcher;

/**
 * controller namespace
 * @internal
 * @var string $GLOBALS['._pirogue.dispatcher_controller_namespace']
 */
$GLOBALS['._pirogue.dispatcher_controller_namespace'] = '';

/**
 * initialize library.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher_controller_namespace']
 * @param string $name the name of the controller that is loaded.
 * @return void.
 */
function _init(string $name) : void
{
    $GLOBALS['._pirogue.dispatcher_controller_namespace'] = $name;
}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher_controller_namespace']
 * @return void
 */
function _dispose() : void
{
    unset($GLOBALS['._pirogue.dispatcher_controller_namespace']);
}

/**
 * determine if user has access.
 * @uses $GLOBALS['._pirogue.dispatcher_controller_namespace']
 * @param ?int $user_id the user id to check for access.
 * @return bool access flag.
 */
function has_access(?int $user_id) : bool
{
    return call_user_func(
        sprintf('%s\has_access', $GLOBALS['._pirogue.dispatcher_controller_namespace']),
        $user_id
    );
}

/**
 * execute controller action.
 * @uses $GLOBALS['._pirogue.dispatcher_controller_namespace']
 * @param string $action the contoller action to invoke.
 * @param array $request_path the request path to pass the action.
 * @param array $request_data the request data to pass the action.
 * @param array $form_data the form data to pass the action.
 * @return array view fragment.
 */
function exec(string $action, array $request_path, array $request_data, array $form_data = []) : array
{
    return call_user_func(
        sprintf('%s\%s', $GLOBALS['._pirogue.dispatcher_controller_namespace'], $action),
        $request_path,
        $request_data,
        $form_data
    );
}
