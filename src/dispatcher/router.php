<?php

/**
 * handle routing of requests.
 * php version 8.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\dispatcher\router;

/**
 * router file's path format for sprintf().
 * @internal
 * @var string $GLOBALS['._pirogue.dispatcher.router.path_format']
 */
$GLOBALS['._pirogue.dispatcher.router.path_format'] = '';

/**
 * a stack containing registered routers.
 * @internal
 * @var string $GLOBALS['._pirogue.dispatcher.router.call_stack']
 */
$GLOBALS['._pirogue.dispatcher.router.call_stack'] = [];

/**
 * initialize router library.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher.router.call_stack']
 * @uses $GLOBALS['._pirogue.dispatcher.router.path_format']
 * @param string $path_format a sprintf format to build the controller's file path.
 * @return void
 */
function _init(string $path_format): void
{
    $GLOBALS['._pirogue.dispatcher.router.path_format'] = $path_format;
    $GLOBALS['._pirogue.dispatcher.router.call_stack'] = [];
}

/**
 * cleanup library variables.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher.router.call_stack']
 * @uses $GLOBALS['._pirogue.dispatcher.router.path_format']
 * @return void
 */
function _dispose(): void
{
    unset(
        $GLOBALS['._pirogue.dispatcher.router.path_format'],
        $GLOBALS['._pirogue.dispatcher.router.call_stack'],
    );
}

/**
 * convert string from kebab case to camel case.
 * @internal
 * @param string $value string to be converted.
 * @return string converted string.
 */
function _convert_case(string $value): string
{
    return str_replace('-', '_', $value);
}

/**
 * find the controller's file path. will search given path until a matching file is found by removing last element in the list each time it fails. this function also includes the file
 * into the execution scope.
 * @internal
 * @uses $GLOBALS['._pirogue.dispatcher.router.router_format']
 * @param array $path an array of strings to build the path from.
 * @return ?string path if file is found or null.
 */
function _build_path(array $path): ?string
{
    if (empty($path)) {
        return null;
    }

    $controller_path = sprintf($GLOBALS['._pirogue.dispatcher.router.path_format'], implode(DIRECTORY_SEPARATOR, $path));
    if (file_exists($controller_path)) {
        require_once $controller_path;
        return $controller_path;
    } else {
        return _build_path(array_slice($path, 0, count($path) - 1));
    }
}

/**
 * translate the (controller name, action name, request method) values to the function impelementing that controller's action - defaults to the request method 'GET'.
 * @internal
 * @uses pirogue\router\convert_case()
 * @param string $controller_namespace name of the controller.
 * @param string $action_name name of the requested action.
 * @param string $request_method the http request method to check for route action.
 * @return ?string null if no route otherwise the name of the routing funciton.
 */
function _build_action(string $controller_namespace, string $action_name, string $request_method = 'GET'): ?string
{
    $function_name = sprintf('%s\%s_%s', $controller_namespace, $action_name, $request_method);
    if (function_exists($function_name)) {
        return strtolower(sprintf('%s_%s', $action_name, $request_method));
    } elseif ('GET' == $request_method) {
        return null;
    } else {
        return 'GET' == $request_method ? null : _build_action($controller_namespace, $action_name);
    }
}

/**
 * create a new route.
 * @uses _build_path()
 * @uses _build_action()
 * @param string $controller_namespace the requested controller.
 * @param string $action_name the requested action.
 * @param string $request_method method of this request.
 * @param ?string $file_name if provided this is used to build filepath for the controller otherwise the controller name is used.
 * @return array a associate array containing the route components in the form of [
 *      'controller_namespace' => $controller_namespace,
 *      'action_name' => $action_name,
 *      'request_method' => $request_method,
 *      'controller_path' => '{controller base directory}/{$controller_namespace}.php',
 *      'action' => '{$controller_namespace}\{$action_name}_{$request_method}',
 * ]
 */
function create(string $controller_namespace, string $action_name, string $request_method, ?string $file_name = null): array
{
    $controller_path = _build_path([$file_name ?? $controller_namespace, $action_name]);
    return [
        'controller_namespace' => _convert_case(strtolower($controller_namespace)),
        'action_name' => $action_name,
        'request_method' => $request_method,
        'controller_path' => $controller_path,
        'action' => '' == $controller_path ? null : _build_action(
            _convert_case($controller_namespace),
            _convert_case($action_name),
            strtolower($request_method),
        )
    ];
}

/**
 * register a new router to call stack.
 * @uses $GLOBALS['._pirogue.dispatcher.router.call_stack']
 * @param array $route the route to add to the callstack, generated using the function create().
 * @return int number of elements on the callstack.
 */
function register(array $route): int
{
    array_unshift($GLOBALS['._pirogue.dispatcher.router.call_stack'], $route);
    return count($GLOBALS['._pirogue.dispatcher.router.call_stack']);
}

/**
 * return the name of the current controller on the callstack.
 * @uses $GLOBALS['._pirogue.dispatcher.router.call_stack']
 * @return array the current route or null if stack is empty.
 */
function current(): ?array
{
    return $GLOBALS['._pirogue.dispatcher.router.call_stack'][0] ?? null;
}
