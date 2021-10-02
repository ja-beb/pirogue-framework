#!/bin/sh
# Download codesniffer and execute run command.


if [ true = "${CODE_SNIFFER}" ]
then
    echo "[entry] download code sniffer."
    cd /project
    curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
    curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar
fi

echo "[entry] exec run command $@"
exec "$@"