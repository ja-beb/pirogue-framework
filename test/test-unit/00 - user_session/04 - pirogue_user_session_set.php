<?php

/**
 * Test pirogue_user_session_set().
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

// load required library.
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'pirogue', 'user_session.php']);
require_once implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include', 'test', 'user_session.php']);


/**
 * Compare two arrays to check for values from list_src in list
 *
 * @param array $list_src the source array to use for checking contents.
 * @param array $list the array to check for contents in.
 * @param array $errors the errors already encountered.
 * @return array list of errors encountered.
 */
function _user_session_compare(array $list_src, array $list, array $errors = []): array
{
    if (!empty($list_src)) {
        $key = key($list_src);
        if (!array_key_exists($key, $list)) {
            array_push($errors, sprintf('00 - variable "%s" not registered.', $key));
        } elseif ($list_src[$key] != $list[$key]) {
            array_push($errors, sprintf('01 - variable "%s"" values do not match.', $key));
        }
        return _user_session_compare(array_slice($list_src, 1), $list, $errors);
    }
    return $errors;
}


// test _pirogue_user_session_set()
pirogue_test_execute('_pirogue_user_session_set()', function () {
    $_SESSION = [];
    pirogue_user_session_init(_PIROGUE_TESTING_USER_SESSION_LABEL);
    foreach ($GLOBALS['._pirogue-testing.user_session.list'] as $key => $value) {
        pirogue_user_session_set($key, $value);
        if ($value != $_SESSION[$GLOBALS['._pirogue.user_session.label_data']][$key]) {
            return sprintf('invalid value for "%s"', $key);
        }
    }
    return '';
});
