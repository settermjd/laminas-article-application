ARG FPM_VERSION=alpine3.15
ARG PHP_VERSION=8.1.6

FROM php:${PHP_VERSION}-fpm-${FPM_VERSION} as base

FROM base as core

ARG ENV

RUN apk --update-cache add autoconf git libzip-dev gcc musl-dev make libzip-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

FROM base as staging

WORKDIR /var/www/html

COPY . .

COPY --from=composer:2.2.7 /usr/bin/composer /usr/bin/
