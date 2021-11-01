<?php

/**
 * controller function.s
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\controller;

/**
 * controller namespace
 * @internal
 * @var string $GLOBALS['._pirogue.controller.namespace']
 */
$GLOBALS['._pirogue.controller.namespace'] = '';

/**
 * initialize library.
 * @internal
 * @uses $GLOBALS['._pirogue.controller.namespace']
 * @param string $name the name of the controller that is loaded.
 * @return void.
 */
_init(string $name): void
{}

/**
 * clean up library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.controller.namespace']
 * @return void
 */
_destroy(): void
{}

/**
 * determine if user has access.
 * @uses $GLOBALS['._pirogue.controller.namespace']
 */
has_access(?int $user_id): bool
{}

/**
 * execute controller action.
 * @uses $GLOBALS['._pirogue.controller.namespace']
 * @param string $action the contoller action to invoke.
 * @param array $request_path the request path to pass the action.
 * @param array $request_data the request data to pass the action.
 * @param array $form_data the form data to pass the action.
 * @return array view fragment.
 */
controller_exec(string $action, array $request_path, array $request_data, array $form_data=[]): array
{}
