/**
 * Base functions for processing xhr request. 
 */
'use strict'

/**
 * Parse JSON object into http query string.
 * @param {JSON} object o JSON object to parse into http query string.
 * @returns {string}
 */
const xhr_build_query = o => Object.keys(o).reduce( (a, k) => {
    a.push(`${k}=${encodeURIComponent(o[k])}`);
    return a;
}, []).join('&');

/**
 * Perform http get request.
 * @param {string} url Url of the request.
 * @returns Promise
 */
const xhr_get = url => new Promise((resolve, reject) => {
	  const xhr = new XMLHttpRequest();
	  xhr.open('GET', url, true);
	  xhr.onload = () => resolve(xhr.responseText);
	  xhr.onerror = () => reject(xhr.statusText);
	  xhr.send();
});

/**
 * Perform http post request.
 * @param {string} url Url of the request.
 * @param {JSON} data The JSON data to post to the server.
 * @returns Promise
 */
const xhr_post = (url,data) => new Promise((resolve, reject) => {
	  const xhr = new XMLHttpRequest();
	  xhr.open('POST', url, true);
	  xhr.onload = () => resolve(xhr.responseText);
	  xhr.onerror = () => reject(xhr.statusText);
	  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	  xhr.send(xhr_build_query(data));
});
