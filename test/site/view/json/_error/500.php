<?php

    /**
     * 500 error page.
     * php version 8.0.0
     *
     * @author Bourg, Sean <sean.bourg@gmail.com>
     * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
     */

    http_response_code(500);
    return [
        'message' => $GLOBALS['.request_data']['exception']->getMessage(),
        'file' => $GLOBALS['.request_data']['exception']->getFile(),
        'line' => $GLOBALS['.request_data']['exception']->getLine()
    ];