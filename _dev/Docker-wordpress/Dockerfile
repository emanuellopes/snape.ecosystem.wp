FROM composer:latest as composer
FROM wordpress:cli-2.5.0-php7.4 as cli
FROM wordpress:5.9.3-fpm-alpine as wordpress
FROM wordpress:5.9.3-fpm-alpine as php

# Add xdebug config
ADD xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#install composer to allow us run tests inside the container
COPY --from=composer /usr/bin/composer /usr/bin/composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installing node.js
ARG NODE_VERSION=16.9.1
ARG NODE_SHA=4e3d852ca7dca751e0c9ac8ae4d78f16b00abc92a29af42ddeff04b27d8ea29b
RUN curl "https://unofficial-builds.nodejs.org/download/release/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64-musl.tar.gz" > "/usr/local/lib/node-latest.tar.gz" \
    && echo "$NODE_SHA  /usr/local/lib/node-latest.tar.gz" | sha256sum -c \
    && tar -xf /usr/local/lib/node-latest.tar.gz -C /usr/local/lib/ \
    && rm -f /usr/local/lib/node-latest.tar.gz
ENV PATH="/usr/local/lib/node-v$NODE_VERSION-linux-x64-musl/bin:${PATH}"

COPY --from=wordpress /usr/src/wordpress/ ./
COPY --from=cli /usr/local/bin/wp /usr/local/bin/wp

# install wp-cli dependencies
RUN apk add --no-cache mysql-client

# install xdebug
RUN set -xe && \
        docker-php-source extract && \
        apk add --no-cache --virtual .build-deps \
            autoconf \
            g++ \
            make \
        && \
        pecl install xdebug && \
        docker-php-ext-enable xdebug && \
        docker-php-source delete && \
        apk del .build-deps && \
        php -v && \
        php -m

#COPY docker-xdebug-* /usr/local/bin/
