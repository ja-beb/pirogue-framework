/**
 * Base functions for processing xhr request. 
 */

'use strict'

/**
 * 
 * @param {string} m HTTP method (ie POST, GET).
 * @param {string} u URL of the request.
 * @param {string} p Data to send with request (POST).
 * @returns Promise
 */
const _xhr_build_request = (m, u, p) => new Promise((rs, rj) => {
	  const xhr = new XMLHttpRequest();
	  xhr.onload = () => rs(xhr.responseText);
	  xhr.onerror = () => rj(xhr.statusText);
	  xhr.open(m, u, true);
	  xhr.send(p);
	});

/**
 * Parse JSON object into http query string.
 * @param {JSON} object o JSON object to parse into http query string.
 * @returns {string}
 */
const xhr_build_query = o => Object.keys(o).reduce( (a, k) => {
    a.push(`${k}=${encodeURIComponent(obj[k])}`);
    return a;
}, []).join('&');

/**
 * Perform http get request.
 * @param {string} url Url of the request.
 * @returns Promise
 */
const xhr_get = url => _xhr_build_request('GET', url, '');

/**
 * Perform http post request.
 * @param {string} url Url of the request.
 * @param {JSON} data The JSON data to post to the server.
 * @returns Promise
 */
const xhr_post = (url,data) => _xhr_build_request('POST', url, xhr_build_query(data));

export { xhr_build_query, xhr_get, xhr_post};