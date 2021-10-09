#!/bin/sh
# Download codesniffer and execute run command.
echo "[entry.sh] start"
echo "[entry.sh] download code sniffer."

if [[ ! -f phpcs.phar ]]
then
   curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
fi

if [[ ! -f phpcbf.phar ]]
then
    curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar
fi

echo "[entry.sh] exec run command $@"
exec "$@"