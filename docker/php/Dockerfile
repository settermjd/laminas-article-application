ARG FPM_VERSION=alpine3.15
ARG PHP_VERSION=8.1.6

FROM php:${PHP_VERSION}-fpm-${FPM_VERSION} as base

FROM base as core

RUN apk --update-cache add autoconf git libzip-dev gcc musl-dev make libzip-dev sqlite \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install sqlite3 so that the database can be generated
RUN docker/php/scripts/create-database.sh

COPY --from=composer:2.2.7 /usr/bin/composer /usr/bin/

COPY . .