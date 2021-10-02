#!/bin/sh
# Run code sniffer check and repair.
# Run all tests.

echo "[run]::codesniffer start"
php /project/phpcbf.phar --standard=/project/phpcs.xml /project/pirogue
php /project/phpcs.phar --standard=/project/phpcs.xml /project/pirogue
echo "[run]::codesniffer completed"

echo "[run]::_all.php start"
php /project/testing/_all.php
echo "[run]::AllTest.php complete"
