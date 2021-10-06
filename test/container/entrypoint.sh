#!/bin/sh
# Download codesniffer and execute run command.


echo "[entry] start"
echo "[entry] CODE_SNIFFER=${CODE_SNIFFER}"
if [ true = "${CODE_SNIFFER}" ]
then
    echo "[entry] download code sniffer."
    cd /var/pirogue-testing
    if [[ -f /project/phpcs.phar ]]
    then
        curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
    fi

    if [[ -f /project/phpcbf.phar ]]
    then
        curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar
    fi
fi

echo "[entry] exec run command $@"
exec "$@"