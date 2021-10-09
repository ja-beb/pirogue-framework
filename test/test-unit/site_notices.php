
/**
 * Test the site notices functions.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

require_once(implode(DIRECTORY_SEPARATOR, [_PIROGUE_TESTING_PATH_INCLUDE, 'pirogue', 'site_notices.php']));

// test pirogue_site_notices_init(string $index): void
pirogue_test_execute('pirogue_user_session_init()', function () {

});

// test pirogue_site_notices_clear(): array
pirogue_test_execute('pirogue_site_notices_clear()', function () {

});

// test pirogue_site_notices_create
pirogue_test_execute('pirogue_site_notices_create()', function () {

});