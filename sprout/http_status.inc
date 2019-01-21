<?php

/**
 * Collection of HTTP status codes used by the framework.
 * 
 * @author Bourg, Sean <sean.bourg@gmail.com>
 */

/**
 * The server has received the request headers and the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request).
 * Sending a large request body to a server after a request has been rejected for inappropriate headers would be inefficient. To have a server check the request's headers, a client must send Expect: 100-continue as a header in its initial request and receive a 100 Continue status code in response before sending the body. If the client receives an error code such as 403 (Unauthorized) or 405 (Method Not Allowed) then it shouldn't send the request's body. The response 417 Expectation Failed indicates that the request should be repeated without the Expect header as it indicates that the server doesn't support expectations (this is the case, for example, of HTTP/1.0 servers).
 *
 * @var string
 */
define('HTTP_STATUS_CONTINUE', 100);

/**
 * Standard response for successful HTTP requests.
 * The actual response will depend on the request method used. In a GET request, the response will contain an entity corresponding to the requested resource. In a POST request, the response will contain an entity describing or containing the result of the action.
 *
 * @var string
 */
define('HTTP_STATUS_OK', 200);

/**
 * The request has been fulfilled, resulting in the creation of a new resource
 *
 * @var string
 */
define('HTTP_STATUS_CREATED', 201);

/**
 * The request has been accepted for processing, but the processing has not been completed.
 * The request might or might not be eventually acted upon, and may be disallowed when processing occurs.
 *
 * @var string
 */
define('HTTP_STATUS_ACCEPTED', 202);

/**
 * The server successfully processed the request and is not returning any content.
 *
 * @var string
 */
define('HTTP_STATUS_NO_CONTENT', 204);

/**
 * The server successfully processed the request, but is not returning any content.
 * Unlike a 204 response, this response requires that the requester reset the document view.
 *
 * @var string
 */
define('HTTP_STATUS_RESET_CONTENT', 205);

/**
 * This and all future requests should be directed to the given URI.
 *
 * @var string
 */
define('HTTP_STATUS_MOVED_PERMANENTLY', 301);

/**
 * This is an example of industry practice contradicting the standard.
 * The HTTP/1.0 specification (RFC 1945) required the client to perform a temporary redirect (the original describing phrase was "Moved Temporarily"), but popular browsers implemented 302 with the functionality of a 303 See Other. Therefore, HTTP/1.1 added status codes 303 and 307 to distinguish between the two behaviours. However, some Web applications and frameworks use the 302 status code as if it were the 303.
 *
 * @var string
 */
define('HTTP_STATUS_FOUND', 302);

/**
 * The response to the request can be found under another URI using the GET method.
 * When received in response to a POST (or PUT/DELETE), the client should presume that the server has received the data and should issue a new GET request to the given URI.
 *
 * @var string
 */
define('HTTP_STATUS_SEE_OTHER', 303);

/**
 * Indicates that the resource has not been modified since the version specified by the request headers If-Modified-Since or If-None-Match.
 * In such case, there is no need to retransmit the resource since the client still has a previously-downloaded copy.
 *
 * @var string
 */
define('HTTP_STATUS_NOT_MODIFIED', 304);

/**
 * In this case, the request should be repeated with another URI; however, future requests should still use the original URI.
 * In contrast to how 302 was historically implemented, the request method is not allowed to be changed when reissuing the original request. For example, a POST request should be repeated using another POST request.
 *
 * @var string
 */
define('HTTP_STATUS_TEMPORARY_REDIRECT', 307);

/**
 * The request and all future requests should be repeated using another URI.
 * 307 and 308 parallel the behaviors of 302 and 301, but do not allow the HTTP method to change. So, for example, submitting a form to a permanently redirected resource may continue smoothly.
 *
 * @var string
 */
define('HTTP_STATUS_PERMANENT_REDIRECT', 308);

/**
 * The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing).
 *
 * @var string
 */
define('HTTP_STATUS_BAD_REQUEST', 400);

/**
 * The request was valid, but the server is refusing action.
 * The user might not have the necessary permissions for a resource, or may need an account of some sort.
 *
 * @var string
 */
define('HTTP_STATUS_FORBIDDEN', 403);

/**
 * The requested resource could not be found but may be available in the future.
 * Subsequent requests by the client are permissible.
 *
 * @var string
 */
define('HTTP_STATUS_NOT_FOUND', 404);

/**
 * A request method is not supported for the requested resource; for example, a GET request on a form that requires data to be presented via POST, or a PUT request on a read-only resource.
 *
 * @var string
 */
define('HTTP_STATUS_METHOD_NOT_ALLOWED', 405);

/**
 * Indicates that the resource requested is no longer available and will not be available again.
 * This should be used when a resource has been intentionally removed and the resource should be purged. Upon receiving a 410 status code, the client should not request the resource in the future. Clients such as search engines should remove the resource from their indices. Most use cases do not require clients and search engines to purge the resource, and a "404 Not Found" may be used instead.
 *
 * @var string
 */
define('HTTP_STATUS_GONE', 410);

/**
 * A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
 *
 * @var string
 */
define('HTTP_STATUS_INTERNAL_SERVER_ERROR', 500);

/**
 * The server either does not recognize the request method, or it lacks the ability to fulfill the request.
 * Usually this implies future availability (e.g., a new feature of a web-service API).
 *
 * @var string
 */
define('HTTP_STATUS_NOT_IMPLEMENTED', 501);

/**
 * The server is currently unavailable (because it is overloaded or down for maintenance).
 * Generally, this is a temporary state.
 *
 * @var string
 */
define('HTTP_STATUS_SERVICE_UNAVAILABLE', 503);

/**
 * Array of header strings for each http status code in this object.
 *
 * @var string[]
 */
define('HTTP_STATUS_HEADERS', [
    HTTP_STATUS_CONTINUE => 'HTTP/1.1 100 Continue',
    HTTP_STATUS_OK => 'HTTP/1.1 200 OK',
    HTTP_STATUS_CREATED => 'HTTP/1.1 201 Created',
    HTTP_STATUS_ACCEPTED => 'HTTP/1.1 202 Accepted',
    HTTP_STATUS_NO_CONTENT => 'HTTP/1.1 204 No Content',
    HTTP_STATUS_RESET_CONTENT => 'HTTP/1.1 205 Reset Content',
    HTTP_STATUS_MOVED_PERMANENTLY => 'HTTP/1.1 301 Moved Permanently',
    HTTP_STATUS_FOUND => 'HTTP/1.1 302 Found',
    HTTP_STATUS_SEE_OTHER => 'HTTP/1.1 303 See Other',
    HTTP_STATUS_NOT_MODIFIED => 'HTTP/1.1 304 Not Modified',
    HTTP_STATUS_TEMPORARY_REDIRECT => 'HTTP/1.1 307 Temporary Redirect',
    HTTP_STATUS_PERMANENT_REDIRECT => 'HTTP/1.1 308 Permanent Redirect',
    HTTP_STATUS_BAD_REQUEST => 'HTTP/1.1 400 Bad Request',
    HTTP_STATUS_FORBIDDEN => 'HTTP/1.1 403 Forbidden',
    HTTP_STATUS_NOT_FOUND => 'HTTP/1.1 404 Not Found',
    HTTP_STATUS_METHOD_NOT_ALLOWED => 'HTTP/1.1 405 Method Not Allowed',
    HTTP_STATUS_GONE => 'HTTP/1.1 410 Gone',
    HTTP_STATUS_INTERNAL_SERVER_ERROR => 'HTTP/1.1 500 Internal Server Error',
    HTTP_STATUS_NOT_IMPLEMENTED => 'HTTP/1.1 501 Not Implemented',
    HTTP_STATUS_SERVICE_UNAVAILABLE => 'HTTP/1.1 503 Service Unavailable'
]);








