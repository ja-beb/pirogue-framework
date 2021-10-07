
function _pirogue_site_display(uri, path, request) {
    console.group('request');
    console.log(`Loaded site = ${uri}`);
    console.log(`Path = ${path}`);
    console.log(`Request = ${request}`);
    console.groupEnd('request');
}