#!/bin/sh
# Run code sniffer check and repair.

phpcs --standard=/pirogue/phpcs.xml /pirogue/include
phpcs --standard=/pirogue/phpcs.xml /pirogue/tests
phpcbf --standard=/pirogue/phpcs.xml /pirogue/include
phpcbf --standard=/pirogue/phpcs.xml /pirogue/tests
