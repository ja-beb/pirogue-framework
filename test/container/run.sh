#!/bin/sh
# Run code sniffer check and repair.
# Run all tests.


if [[ 1 == $((EXECUTE_TEST|1)) ]]
then
    echo "[run]::codesniffer start"
    php /var/pirogue-testing/phpcbf.phar --standard=/var/pirogue-testing/phpcs.xml /var/pirogue-testing/pirogue
    php /var/pirogue-testing/phpcs.phar --standard=/var/pirogue-testing/phpcs.xml /var/pirogue-testing/pirogue
    echo "[run]::codesniffer completed"
fi    

# Run unit testing.
if [[ 2 == $((EXECUTE_TEST|2)) ]]
then
    echo "[run] Unit Testing - start"
    php /var/pirogue-testing/test/_all.php
    echo "[run] Unit Testing - complete"
fi
