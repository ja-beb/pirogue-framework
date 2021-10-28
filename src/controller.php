<?php

/**
 * library used to work with controllers at a high level.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue;

/**
 * the name of the current controller.
 *
 * @internal use by libary only.
 * @var string $GLOBALS['.pirogue.controller.name']
 */
$GLOBALS['.pirogue.controller.name'] = '';

/**
 * initialize view library.
 *
 * @uses $GLOBALS['.pirogue.controller.name']
 * @param string $name the name of the module to initialize.
 */
function controller_init(string $name): void
{
    $GLOBALS['.pirogue.controller.name'] = $name;
}

/**
 * check if user has access.
 *
 * @uses $GLOBALS['.pirogue.controller.name']
 * @uses _controller_build_function_name()
 *
 * @param ?int $user_id user id to check
 * @return bool has access boolean flag.
 */
function controller_has_access(?int $user_id): bool
{
    // check for action level
    $func = _controller_build_function_name([$GLOBALS['.pirogue.controller.name'], 'has_access']);
    return function_exists($func) ? call_user_func($func, $user_id) : true;
}

/**
 * translate action and request method to the route function. will default to request method 'get' if none found.
 *
 * @uses $GLOBALS['.pirogue.controller.name']
 * @uses _controller_build_function_name()
 * @uses controller_get_action()
 *
 * @param string $action the action to check for.
 * @param string $method the http method to check for route action.
 * @return ?string null if no route otherwise the name of the routing funciton.
 */
function controller_get_action(string $action, string $method = 'GET'): ?string
{
    $route_name = _controller_build_function_name([$GLOBALS['.pirogue.controller.name'], $action, $method]);
    if (function_exists($route_name)) {
        return $route_name;
    } else {
        return 'GET' == $method ? null : controller_get_action($action, 'GET');
    }
}

/**
 * build function name.
 * @internal
 * @param array $parts the parts of the function to build.
 * @return string function name.
 */
function _controller_build_function_name(array $parts): string
{
    return str_replace('-', '_', strtolower(implode('_', $parts)));
}
