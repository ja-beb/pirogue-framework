<?php

  /**
   * 404 error page.
   * php version 8.0.0
   *
   * @author Bourg, Sean <sean.bourg@gmail.com>
   * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
   */

  // Set up page.
  http_response_code(404);
  return [
    'message' => 'api not found',
    '.request_path' => $GLOBALS['.request_path'],
    '.request_page' => $GLOBALS['.request_page'],
    '._request_view' => $GLOBALS['._request_view'],
    '._dispatcher_view' => $GLOBALS['._dispatcher_view']
  ];