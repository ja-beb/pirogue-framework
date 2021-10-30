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
}

/**
 * convert string from kebab case to camel case.
 *
 * @param string $value string to be converted.
 * @return string converted stgring.
 */
function controller_string_convert(string $value): string
{
    return strtolower(str_replace('-', '_', $value));
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
    $function_name = controller_string_convert(sprintf('%s\%s_%s', $GLOBALS['._pirogue.controller.name'], $action, $method));
    echo $function_name;
    if (function_exists($function_name)) {
        return $function_name;
    } else {
        return 'GET' == $method ? null : controller_get_action($action, 'GET');
    }
}
