FROM php:8.0-alpine
LABEL maintainer="sean bourg <sean.bourg@gmail.com>"

RUN mkdir /var/pirogue \
    && mkdir /var/pirogue/include

WORKDIR /var/pirogue
COPY ./entrypoint.sh ./run.sh ./phpcs.xml ./

RUN chmod +x entrypoint.sh run.sh \
    && docker-php-ext-install mysqli;

ENTRYPOINT ["/var/pirogue/entrypoint.sh"]
CMD ["/var/pirogue/run.sh"]
