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
 * @var string $GLOBALS['._pirogue.controller.name']
 */
$GLOBALS['._pirogue.controller.name'] = '';


/**
 * default access level - used when no access is provided by dispatcher.
 *
 * @internal use by libary only.
 * @var bool $GLOBALS['._pirogue.controller.default_access']
 */
$GLOBALS['._pirogue.controller.default_access'] = '';

/**
 * initialize view library.
 *
 * @uses $GLOBALS['._pirogue.controller.name']
 * @uses $GLOBALS['._pirogue.controller.default_access']
 *
 * @param string $name the name of the module to initialize.
 */
function controller_init(string $name, bool $default_access = true): void
{
    $GLOBALS['._pirogue.controller.name'] = $name;
    $GLOBALS['._pirogue.controller.default_access'] = $default_access;
}

/**
 * build function name.
 *
 * @internal
 *
 * @param array $parts the parts of the function to build.
 * @return string function name.
 */
function _controller_build_function_name(array $parts): string
{
    return str_replace('-', '_', strtolower(implode('_', $parts)));
}

/**
 * return current controller's name.
 *
 * @uses $GLOBALS['._pirogue.controller.name']
 *
 * @return string name of the current controller.
 */
function controller_current(): ?string
{
    return $GLOBALS['._pirogue.controller.name'];
}

/**
 * check if user has access - will use controller library's default access value if no access function is defined by the current controller.
 *
 * @uses $GLOBALS['._pirogue.controller.name']
 * @uses $GLOBALS['._pirogue.controller.default_access']
 * @uses _controller_build_function_name()
 *
 * @param ?int $user_id user id to check
 * @return bool has access boolean flag
 */
function controller_has_access(?int $user_id): bool
{
    // check for action level
    $func = _controller_build_function_name([$GLOBALS['._pirogue.controller.name'], 'has_access']);
    return function_exists($func) ? call_user_func($func, $user_id) : $GLOBALS['._pirogue.controller.default_access'];
}

/**
 * translate action and request method to the route function. will default to request method 'get' if none found.
 *
 * @uses $GLOBALS['._pirogue.controller.name']
 * @uses _controller_build_function_name()
 *
 * @param string $action the action to check for.
 * @param string $method the http method to check for route action.
 * @return ?string null if no route otherwise the name of the routing funciton.
 */
function controller_get_action(string $action, string $method = 'GET'): ?string
{
    $route_name = _controller_build_function_name([$GLOBALS['._pirogue.controller.name'], $action, $method]);
    if (function_exists($route_name)) {
        return $route_name;
    } else {
        return 'GET' == $method ? null : controller_get_action($action, 'GET');
    }
}
