#!/bin/sh
# Run code sniffer check and repair.
# Run all tests.


if [ true = "${CODE_SNIFFER}" ]
then
    echo "[run]::codesniffer start"
    php /var/pirogue-testing/phpcbf.phar --standard=/var/pirogue-testing/phpcs.xml /var/pirogue-testing/pirogue
    php /var/pirogue-testing/phpcs.phar --standard=/var/pirogue-testing/phpcs.xml /var/pirogue-testing/pirogue
    echo "[run]::codesniffer completed"
fi    

# Run unit testing.
echo "[run] Unit Testing - start"
php /var/pirogue-testing/test/_all.php
echo "[run] Unit Testing - complete"
