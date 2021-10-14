<?php

/**
 * Perform all testing of framework. Loads external test files from
 * the unit-test/ directory
 */

// PHP error handler: all warnings and errors are reported and handled.
set_error_handler(
    fn ($severity, $message, $file, $line) => throw new ErrorException($message, $severity, $severity, $file, $line)
);
ini_set("display_errors", 1);
error_reporting(E_ALL | E_STRICT);

// define base folder.
// '/var/pirogue';
define('_PIROGUE_TESTING_PATH', '/pirogue');
define('_PIROGUE_TESTING_PATH_INCLUDE', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'include']));
define('_PIROGUE_TESTING_PATH_VIEW', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'view']));
define('_PIROGUE_TESTING_PATH_CONFIG', implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH, 'config']));

// Global variables for test counts
$GLOBALS['._pirogue_test.count_test'] = 0;
$GLOBALS['._pirogue_test.count_errors'] = 0;

/**
 * Log error message.
 *
 * @param string $label the test's label.
 * @param array $errors list of errors encoutered. if successful the array is empty.
 */
function _pirogue_test_log(string $label, string $error_message = ''): void
{
    if ('' == $error_message) {
        printf("[PASSED] %s\n", $label);
    } else {
        $GLOBALS['._pirogue_test.count_errors']++;
        printf("[FAILED] %s\n", $label);
        printf("%s\n", $error_message);
    }
}

/**
 * Execute unit test.
 *
 * @param string $label the test's label.
 * @param callable $callable function to perform test, returns an array of error messages or empty if no
 * errors were encountered.
 */
function pirogue_test_execute(string $label, $callable): void
{
    try {
        $GLOBALS['._pirogue_test.count_test']++;
        _pirogue_test_log($label, $callable() ?? '');
    } catch (Throwable $e) {
        _pirogue_test_log($label, sprintf('%s (%s:%d)', $e->getMessage(), $e->getFile(), $e->getLine()));
    }
}

// scan for child directories and execute any /^[^_].*.php$/ files encountered.
$_test_files_loaded = 0;
foreach (array_filter(glob(implode(DIRECTORY_SEPARATOR, [__DIR__, '*'])), 'is_dir') as $_test_group) {
    foreach (scandir($_test_group) as $_test_file) {
        $_test_path = implode(DIRECTORY_SEPARATOR, [$_test_group, $_test_file]);
        if (!is_dir($_test_path) && preg_match('/^[^_].*\.php$/', $_test_file)) {
            try {
                printf("%s/%s\n", basename($_test_group), basename($_test_file));
                $_test_files_loaded++;
                require $_test_path;
            } catch (Throwable $e) {
                _pirogue_test_log(
                    "require $_test_path",
                    sprintf('%s (%s:%d)', $e->getMessage(), $e->getFile(), $e->getLine())
                );
            } finally {
                echo "\n";
            }
        }
    }
}

// Report result counts.
echo "\n";
printf("Files loaded______: %s\n", $_test_files_loaded);
printf("Tests performed___: %s\n", $GLOBALS['._pirogue_test.count_test']);
printf("Errors encountered: %s\n", $GLOBALS['._pirogue_test.count_errors']);
echo "\n";
