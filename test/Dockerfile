FROM php:8.0-alpine
LABEL maintainer="sean bourg <sean.bourg@gmail.com>"

WORKDIR /tmp

COPY ./bin/test.sh ./bin/check.sh ./bin/runAll.sh ./phpcs.xml ./

RUN curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar \
    && curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar \
    && cp phpcs.phar /usr/local/bin/phpcs \
    && cp phpcbf.phar /usr/local/bin/phpcbf \
    && mv /tmp/test.sh /usr/local/bin/test.sh \
    && mv /tmp/check.sh /usr/local/bin/check.sh \
    && mv /tmp/runAll.sh /usr/local/bin/runAll.sh \
    && chmod +x /usr/local/bin/phpcs \
    && chmod +x /usr/local/bin/phpcbf \
    && chmod +x /usr/local/bin/test.sh \
    && chmod +x /usr/local/bin/check.sh \
    && chmod +x /usr/local/bin/runAll.sh \
    && phpcs --config-set show_progress 1 \
    && phpcs --config-set colors 1 \
    && phpcs --config-set report_width 140 \
    && phpcs --config-set encoding utf-8  \
    && docker-php-ext-install mysqli;

WORKDIR /pirogue
RUN mkdir /pirogue/include \
    && mv /tmp/phpcs.xml /pirogue/phpcs.xml

CMD ["runAll.sh"]
