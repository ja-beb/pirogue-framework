#!/bin/sh


echo "Building...."

cd /project

curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar

exec "$@"