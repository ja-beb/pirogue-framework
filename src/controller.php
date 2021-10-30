<?php

/**
 * library used to work with controllers at a high level.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\controller;

/**
 * controller file format.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.controller.path_format']
 */
$GLOBALS['._pirogue.controller_import.path_format'] = '';

/**
 * controller call stack.
 *
 * @internal
 * @var string $GLOBALS['._pirogue.controller.call_stack']
 */
$GLOBALS['._pirogue.controller_import.call_stack'] = [];

/**
 * initialize controller library.
 *
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @uses $GLOBALS['._pirogue.controller_import.path_format']
 *
 * @param string $name the name of the module to initialize.
 * @return void
 */
function _init(string $name): void
{
    $GLOBALS['._pirogue.controller_import.path_format'] = $name;
    $GLOBALS['._pirogue.controller_import.call_stack'] = [];
}

/**
 * finalize controller library.
 *
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @uses $GLOBALS['._pirogue.controller_import.path_format']
 *
 * @return void
 */
function _dispose(): void
{
    unset(
        $GLOBALS['._pirogue.controller_import.path_format'],
        $GLOBALS['._pirogue.controller_import.call_stack'],
    );
}

/**
 * convert string from kebab case to camel case.
 *
 * @param string $value string to be converted.
 * @return string converted string.
 */
function convert_case(string $value): string
{
    return strtolower(str_replace('-', '_', $value));
}

/**
 * return the name of the current controller on the callstack.
 *
 * @uses $GLOBALS['._pirogue.controller_import.call_stack'],
 *
 * @return string name of the current controller or null if no controller has been registered.
 */
function current_controller(): ?string
{
    return current($GLOBALS['._pirogue.controller_import.call_stack']);
}

/**
 * register new controller to callstack.
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @param string $name name of controller to add to callstack.
 * @return int number of elements on the callstack.
 */
function register(string $name): int
{
    array_unshift($GLOBALS['._pirogue.controller_import.call_stack'], $name);
    return count($GLOBALS['._pirogue.controller_import.call_stack']);
}

/**
 * build the path to the desired controller given user inputed array.
 * will remove last element of the array until it is empty or the file has been found.
 *
 * @uses $GLOBALS['._pirogue.controller_import.controller_format']
 * @param array $path an array of strings to build the path from.
 * @return ?string path if file is found or null.
 */
function build_path(array $path): ?string
{
    if (empty($path)) {
        return null;
    } else {
        $file = sprintf($GLOBALS['._pirogue.controller_import.path_format'], implode(DIRECTORY_SEPARATOR, $path));
        return file_exists($file) ? $file : build_path(array_slice($path, 0, count($path) - 1));
    }
}

/**
 * translate (controller name, action name, request method) to the routing function.
 * this will default to request method 'get' if none found.
 *
 * @uses pirogue\controller\convert_case() to clean string of kebab case passed in from the HTTP request path.
 *
 * @param string $controller_name name of the controller.
 * @param string $action_name name of the requested action.
 * @param string $request_method the http request method to check for route action.
 * @return ?string null if no route otherwise the name of the routing funciton.
 */
function build_action(string $controller_name, string $action_name, string $request_method = 'GET'): ?string
{
    $function_name = convert_case(sprintf('%s\%s_%s', $controller_name, $action_name, $request_method));
    if (function_exists($function_name)) {
        return $function_name;
    } else {
        return 'GET' == $request_method ? null : build_action($controller_name, $action_name, 'GET');
    }
}
