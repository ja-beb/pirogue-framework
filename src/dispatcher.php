<?php

/**
 * library for handling basic dispatcher actions.
 * php version 8.0.0
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace pirogue\dispatcher;

use ErrorException;

/**
 * the site's base address.
 * @var string $GLOBALS['.pirogue.dispatcher.address']
 */
$GLOBALS['.pirogue.dispatcher.address'] = '';

/**
 * the requested path.
 * @var string $GLOBALS['.pirogue.dispatcher.request_path']
 */
$GLOBALS['.pirogue.dispatcher.request_path'] = '';

/**
 * the requested data.
 * @var string $GLOBALS['.pirogue.dispatcher.request_data']
 */
$GLOBALS['.pirogue.dispatcher.request_data'] = [];


/**
 * store regsitered pathes.
 * @var array $GLOBALS['._pirogue.dispatcher.path_list']
 */
$GLOBALS['._pirogue.dispatcher.path_list'] = [];


/**
 * controller file's path format for sprintf().
 * @internal
 * @var string $GLOBALS['._pirogue.dispatcher_route.path_format']
 */
$GLOBALS['._pirogue.dispatcher_route.path_format'] = '';

/**
 * a stack containing called routes in a FILO order.
 * @internal
 * @var string $GLOBALS['._pirogue.dispatcher.call_stack']
 */
$GLOBALS['._pirogue.dispatcher.call_stack'] = [];

/**
 * setup dispatcher library.
 * @internal
 * @uses $GLOBALS['.pirogue.dispatcher.address']
 * @uses $GLOBALS['.pirogue.dispatcher.request_path']
 * @uses $GLOBALS['.pirogue.dispatcher.request_data']
 * @uses $GLOBALS['._pirogue.dispatcher.path_list']
 * @uses $GLOBALS['._pirogue.dispatcher_route.path_format']
 * @uses $GLOBALS['._pirogue.dispatcher.call_stack']
 * @param string $address the base address for the site.
 * @param string $request_path a string containing the path the the client's requested resource.
 * @param array $request_data array containing the request data passed from the client.
 * @param string $controller_path_format file path format for the controller variable.
 * @return void
 */
function _dispatcher_init(
    string $address,
    string $request_path,
    array $request_data,
    string $controller_path_format,
): void {

    $GLOBALS['.pirogue.dispatcher.address'] = $address;
    $GLOBALS['.pirogue.dispatcher.request_path'] = $request_path;
    $GLOBALS['.pirogue.dispatcher.request_data'] = $request_data;
    $GLOBALS['._pirogue.dispatcher_route.path_format'] = $controller_path_format;
    $GLOBALS['._pirogue.dispatcher.path_list'] = [];
    $GLOBALS['._pirogue.dispatcher.call_stack'] = [];
}

/**
 * destory the diispatcher library state (variables).
 * @internal
 * @uses $GLOBALS['.pirogue.dispatcher.address']
 * @uses $GLOBALS['.pirogue.dispatcher.request_path']
 * @uses $GLOBALS['.pirogue.dispatcher.request_data']
 * @uses $GLOBALS['._pirogue.dispatcher.path_list']
 * @uses $GLOBALS['._pirogue.dispatcher_route.path_format']
 * @uses $GLOBALS['._pirogue.dispatcher.call_stack']
 * @return void
 */
function _dispatcher_dispose(): void
{
    unset(
        $GLOBALS['.pirogue.dispatcher.address'],
        $GLOBALS['.pirogue.dispatcher.request_path'],
        $GLOBALS['.pirogue.dispatcher.request_data'],
        $GLOBALS['._pirogue.dispatcher.path_list'],
        $GLOBALS['._pirogue.dispatcher_route.path_format'],
        $GLOBALS['._pirogue.dispatcher.call_stack'],
    );
}

/**
 * send content to user.
 * @internal
 * @param string $content the content that will be sent to the client.
 * @return void
 */
function _dispatcher_send(string $content): void
{
    ob_start('ob_gzhandler');

    //  build and send etag based on content.
    $etag = md5($content);
    header(sprintf('ETAG: %s', $etag));

    // get reesponse code.
    $http_status_code = http_response_code();
    if (false == array_key_exists('HTTP_IF_NONE_MATCH', $_SERVER)) {
        // not cached by client.
        http_response_code($http_status_code);
        echo $content;
    } elseif ($etag == $_SERVER['HTTP_IF_NONE_MATCH']) {
        // cached by client, no need to send content.
        http_response_code(200 == $http_status_code ? 304 : $http_status_code);
    } else {
        // send content.
        http_response_code($http_status_code);
        echo $content;
    }

    ob_end_flush();
}

/**
 * translate a PHP triggered errors into SPL ErrorException instance.
 * @throws ErrorException
 * @uses ErrorException
 * @internal
 * @param int $number the error code encountered.
 * @param string $message a message describing the error.
 * @param string $file the file the error was encountered in.
 * @param int $line the line that the error was encountered at.
 * @return boolean continuation flag.
 */
function _dispatcher_error_handler(int $number, string $message, string $file, int $line): bool
{
    if ($number & error_reporting()) {
        throw new ErrorException($message, 0, $number, $file, $line);
    }
    return false;
}

/**
 * redirect user to new address. this function calls exit() to terminated any further code execution.
 * @param string $address the address to redirect too. If no address is specified the page is refreshed.
 * @param int $status_code the http status code to use in the redirect process.
 * @return void.
 */
function dispatcher_redirect(string $address, int $status_code = 301): void
{
    header(sprintf('Location: %s', $address), true, $status_code);
    exit();
}


//
// Helper functions (base actions).
//

/**
 * convert string from kebab case to camel case. used to convert user provided route to a controller's name.
 * @internal
 * @param string $value string to be converted.
 * @return string converted string.
 */
function _dispatcher_route_convert_case(string $value): string
{
    return str_replace('-', '_', $value);
}

/**
 * clear all output buffers and return contents.
 * @internal
 * @return string contents of all buffers.
 */
function _dispatcher_buffer_clear(): string
{
    $buffer = '';
    while (0 < ob_get_level()) {
        $buffer .= ob_get_clean();
    }
    return $buffer;
}


//
// URL functions.
//


/**
 * create url to resource relative to site base.
 * @uses $GLOBALS['.pirogue.dispatcher.address']
 * @param string $path the path to the resource.
 * @param array $data an array containing key => value pairs of data use as request parameters.
 * @return string the url created from user input.
 */
function dispatcher_url_create(string $path, array $data): string
{
    $pattern_code = ('' == $path ? 0 : 1) | (empty($data) ? 0 : 2);
    return sprintf(
        match ($pattern_code) {
            0 => '%s',
            1 => '%s/%s',
            2 => '%s?%s',
            3 => '%s/%s?%s',
        },
        $GLOBALS['.pirogue.dispatcher.address'],
        $path,
        http_build_query($data)
    );
}

/**
 * get the current url.
 * @uses _url_create()
 * @uses $GLOBALS['.pirogue.dispatcher.request_path']
 * @uses $GLOBALS['.pirogue.dispatcher.request_data']
 * @return string the current requested url.
 */
function dispatcher_url_current(): string
{
    return url_create(
        path: $GLOBALS['.pirogue.dispatcher.request_path'],
        data: $GLOBALS['.pirogue.dispatcher.request_data']
    );
}


//
// Path functions.
//

/**
 * register a new server.
 * @uses $GLOBALS['._pirogue.dispatcher.path_list']
 * @param string $name the name of the server to register.
 * @param string $address the address of the server to register.
 * @return void.
 */
function dispatcher_path_register(string $name, string $address): void
{
    $GLOBALS['._pirogue.dispatcher.path_list'][$name] = $address;
}

/**
 * get a registered url.
 * @uses $GLOBALS['._pirogue.dispatcher.path_list']
 * @param string $name the name of the url to retrieve.
 * @return string the registgered url or null if not registered.
 */
function dispatcher_path_get(string $name): ?string
{
    return $GLOBALS['._pirogue.dispatcher.path_list'][$name] ?? null;
}


//
// Callback functions.
//

/**
 * convert url into a callback string to be passed as a http query variable.
 * @param string $url the url to create a callback from.
 * @return string parsed callback.
 */
function dispatcher_callback_create(string $url): string
{
    return urlencode($url);
}

/**
 * parse callback string into a url.
 * @param string $callback the request data.
 * @return array parsed callback in the form of a url.
 */
function dispatcher_callback_parse(string $callback): string
{
    return urldecode($callback);
}

/**
 * convert path from string to array and removes the '_' prefix that denotes a internal path name.
 * @param string $path the path to convert to array.
 * @return array an array containing the path.
 */
function dispatcher_request_path_parse(string $path): array
{
    $result = [];
    foreach (explode('/', $path) as $key => $value) {
        $_tmp = preg_replace('/^_*/', '', $value);
        if ('' != $_tmp) {
            $result[$key] = $_tmp;
        }
    }
    return $result;
}

//
// Router functions.
//

/**
 * create a new route array.
 * @param string $namespace the namespace to use for this route.
 * @param string $action the routes's action.
 * @param string $method the requset method of this route.
 * @return array a associate array containing the route components in the form of [
 *      'namespace' => $namespace,
 *      'action' => $action,
 *      'method' => $method
 * ]
 */
function dispatcher_route_create(string $namespace, string $action, string $method): array
{
    $controller_path = _build_path($file_path);
    return [
        'namespace' => $namespace,
        'action' => $action,
        'method' => $method,
    ];
}

/**
 * register a new route to call stack.
 * @uses $GLOBALS['._pirogue.dispatcher.call_stack']
 * @param array $route the route to add to the callstack, generated using the function create().
 * @return int number of elements on the callstack.
 */
function dispatcher_route_register(array $route): int
{
    array_unshift($GLOBALS['._pirogue.dispatcher.call_stack'], $route);
    return count($GLOBALS['._pirogue.dispatcher.call_stack']);
}

/**
 * return the name of the current controller on the callstack.
 * @uses $GLOBALS['._pirogue.dispatcher.call_stack']
 * @return array the current route or null if stack is empty.
 */
function dispatcher_route_current(): ?array
{
    return $GLOBALS['._pirogue.dispatcher.call_stack'][0] ?? null;
}


/**
 * find the controller's file path. will search given path until a matching file is found by removing last element in the list each time it fails. this function also includes the file
 * into the execution scope.
 * @uses $GLOBALS['._pirogue.dispatcher_route.path_format']
 * @param array $path an array of strings to build the path from.
 * @return ?string path if file is found or null.
 */
function dispatcher_controller_path_build(array $path): ?string
{
    if (empty($path)) {
        return null;
    }

    $controller_path = sprintf($GLOBALS['._pirogue.dispatcher_route.path_format'], implode(DIRECTORY_SEPARATOR, $path));
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
 * @param string $controller_namespace name of the controller.
 * @param string $action_name name of the requested action.
 * @param string $request_method the http request method to check for route action.
 * @return ?string null if no route otherwise the name of the routing funciton.
 */
function _dispatcher_route_build_action(string $controller_namespace, string $action_name, string $request_method = 'get'): ?string
{
    $function_name = sprintf('%s\%s_%s', $controller_namespace, $action_name, $request_method);
    if (function_exists($function_name)) {
        return strtolower(sprintf('%s_%s', $action_name, $request_method));
    } elseif ('get' == $request_method) {
        return null;
    } else {
        return _build_action($controller_namespace, $action_name);
    }
}