<?php
/**
 * HTML fatal error - used when all else fails.
 *
 * @author Bourg, Sean P. <sean.bourg@gmail.com>
 */

// Clear any remaining buffers.
while (0 < ob_get_level()) {
    ob_get_clean();
}

ob_start('ob_gzhandler');

// failsafe errors.
header('Content-Type: text/html');
header('X-Powered-By: pirogue php');
header(sprintf('X-Execute-Milliseconds: %f', (microtime(true) - $GLOBALS['._pirogue.dispatcher.start_time']) * 1000));
http_response_code(500);

echo 'fatal error';
if ($GLOBALS['._pirogue.dispatcher.failsafe_exception']) {
    printf('ERROR %s: (%s:%d)', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getMessage(), str_replace('C:\\inetpub\example-site\view', '', $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getFile()), $GLOBALS['._pirogue.dispatcher.failsafe_exception']->getLine());
} else {
    echo 'Unknown exception encountered';
}
ob_flush();
exit();
