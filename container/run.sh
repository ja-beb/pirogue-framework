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

# Run unit testing.
echo "[run] Unit Testing - start"
php /project/testing/_all.php
echo "[run] Unit Testing - complete"
