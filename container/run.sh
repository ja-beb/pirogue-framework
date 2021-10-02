#!/bin/sh
# Run code sniffer check and repair.
# Run all tests.

if [ true = "${CODE_SNIFFER}" ]
then
    echo "[run]::codesniffer start"
    php /project/phpcbf.phar --standard=/project/phpcs.xml /project/pirogue
    php /project/phpcs.phar --standard=/project/phpcs.xml /project/pirogue
    echo "[run]::codesniffer completed"
fi    



echo "[run]::_all.php start"
php /project/testing/_all.php
echo "[run]::_all.php complete"
