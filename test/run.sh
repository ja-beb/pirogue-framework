#!/bin/sh
# Run code sniffer check and repair.
# Run all tests.

# code sniffer.
echo "[run.sh]::codesniffer start"
php ./phpcs.phar --standard=./phpcs.xml ./include
php ./phpcbf.phar --standard=./phpcs.xml ./include
echo "[run.sh]::codesniffer completed"

# run unit testing.
echo "[run.sh] Unit Testing - start"
php ./test/_all.php
echo "[run.sh] Unit Testing - complete"

# complete.
echo "[run.sh] COMPLETED";