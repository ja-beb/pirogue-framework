<?php

    /**
     * Test the site notices functions.
     * php version 8.0.0
     *
     * @author Bourg, Sean <sean.bourg@gmail.com>
     * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
     */

    require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'site_notices.php']));

    // init session variables (reset for testing).
    $_SESSION = [];

    // test pirogue_site_notices_init(string $index): void
    pirogue_test_execute('pirogue_site_notices_init()', function () {
        $errors = [];
        $label = '@pirogue_site_notices_init()::testing';

        if ('' !=  $GLOBALS['._pirogue.site_notices.index']) {
            array_push(
                $errors,
                "00 - site notice index set before initialized ({$GLOBALS['._pirogue.site_notices.index']})."
            );
        }

        pirogue_site_notices_init($label);
        if ('' ==  $GLOBALS['._pirogue.site_notices.index']) {
            array_push($errors, '01 - site notice index not initialized.');
        } elseif ($GLOBALS['._pirogue.site_notices.index'] != $label) {
            array_push($errors, '02 - site notice index not properly set.');
        }

        if (!array_key_exists($GLOBALS['._pirogue.site_notices.index'], $_SESSION)) {
            array_push($errors, '03 - site notice array not initialzed.');
        } elseif (!empty($_SESSION[$GLOBALS['._pirogue.site_notices.index']])) {
            array_push($errors, '04 - site notice array contains values.');
        }
        return $errors;
    });

    // test pirogue_site_notices_clear(): array
    pirogue_test_execute('pirogue_site_notices_clear()', function () {
        $errors = [];
        return $errors;
    });

    // test pirogue_site_notices_create
    pirogue_test_execute('pirogue_site_notices_create()', function () {
        $errors = [];
        return $errors;
    });
