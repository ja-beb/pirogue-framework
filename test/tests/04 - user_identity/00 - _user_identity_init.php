<?php

/**
 * Testing for pirogue\_user_identity_init() and pirogue\_user_identity_dispose()
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

use function pirogue\_user_identity_init;
use function pirogue\_user_identity_dispose;

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_identity.php']);

// set up testin environment.
$_SESSION = [];
$GLOBALS['._pirogue-testing.user_identity.label'] = '._pirogue-testing.user_identity';
_user_identity_init($GLOBALS['._pirogue-testing.user_identity.label']);

pirogue_test_execute('pirogue\_user_identity_init(): initialize ._pirogue.user_identity.label', function () {
    if (false == array_key_exists('._pirogue.user_identity.label', $GLOBALS)) {
        return 'var "._pirogue.user_identity.label" not initialized.';
    } elseif ($GLOBALS['._pirogue-testing.user_identity.label'] != $GLOBALS['._pirogue.user_identity.label']) {
        return 'var "._pirogue.user_identity.label" not properly set.';
    } else {
        return '';
    }
});

// test _init() - user data is initialized to a null value.
pirogue_test_execute('pirogue\_user_identity_init(): user data', function () {
    if (false == array_key_exists($GLOBALS['._pirogue-testing.user_identity.label'], $_SESSION)) {
        return sprintf('session variable "%s" not initialized.', $GLOBALS['._pirogue-testing.user_identity.label']);
    } elseif (null != $_SESSION[$GLOBALS['._pirogue-testing.user_identity.label']]) {
        return sprintf(
            'session variable "%s" not properly set (type=%s).',
            $GLOBALS['._pirogue.user_identity.label'],
            gettype($_SESSION[$GLOBALS['._pirogue.user_identity.label']])
        );
    } else {
        return '';
    }
});

_user_identity_dispose();
pirogue_test_execute('pirogue\_user_identity_dispose(): ._pirogue.user_identity.label', function () {
    return array_key_exists('._pirogue.user_identity.label', $GLOBALS) ? 'value still set.' : '';
});

// clean up testin environment.
unset($_SESSION);
