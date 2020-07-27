FROM php:7.4-fpm-alpine

RUN set -xe && apk update && apk add --no-cache \
    libzip \
    bash \
    curl \
    libmcrypt \
    libmcrypt-dev \
    libxml2-dev \
    postgresql-dev \
    pcre-dev \
    git \
    autoconf \
    g++ \
    make \
    icu-dev \
    && docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && docker-php-ext-install pdo_pgsql pcntl sockets soap intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY symfony.ini /usr/local/etc/php/conf.d/symfony.ini

COPY xdebug.ini  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www
