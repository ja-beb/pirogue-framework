<?php

/**
 * controller handing.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\controller;

/**
 * controller file's path format for sprintf().
 * @internal
 * @var string $GLOBALS['._pirogue.controller.path_format']
 */
$GLOBALS['._pirogue.controller_import.path_format'] = '';

/**
 * a stack containing reegistered controllers.
 * @internal
 * @var string $GLOBALS['._pirogue.controller.call_stack']
 */
$GLOBALS['._pirogue.controller_import.call_stack'] = [];

/**
 * initialize controller library.
 * @internal
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @uses $GLOBALS['._pirogue.controller_import.path_format']
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
 * @internal
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @uses $GLOBALS['._pirogue.controller_import.path_format']
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
 * @param string $value string to be converted.
 * @return string converted string.
 */
function convert_case(string $value): string
{
    return strtolower(str_replace('-', '_', $value));
}

/**
 * return the name of the current controller on the callstack.
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @return array the current route or null if stack is empty.
 */
function current(): ?array
{
    return \current($GLOBALS['._pirogue.controller_import.call_stack']) ?? null;
}

/**
 * register new controller to callstack.
 * @uses $GLOBALS['._pirogue.controller_import.call_stack']
 * @param string controller_name the name of controller that is being routed.
 * @param string string $action_name the name of the action that is being routed.
 * @param string string $request_method the request method of this route.
 * @return int number of elements on the callstack.
 */
function register(string $controller_name, string $action_name, string $request_method): int
{
    array_unshift($GLOBALS['._pirogue.controller_import.call_stack'], 
        [
            'controller_name' => $controller_name,
            'action_name' => $action_name,
            'request_method' => $request_method,
        ]
    );
    return count($GLOBALS['._pirogue.controller_import.call_stack']);
}

/**
 * find the path to a controller file.
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
 * translate (controller name, action name, request method) to the routing function - defaults to the request method 'get' if not found.
 * @uses pirogue\controller\convert_case()
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
