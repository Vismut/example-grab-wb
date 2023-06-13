FROM php:8.1-fpm-alpine

RUN apk update && apk upgrade
RUN apk add --no-cache gcc musl-dev make autoconf curl-dev wget zip unzip libzip-dev

RUN docker-php-ext-install bcmath curl

WORKDIR /opt/app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /opt/app

RUN composer install --no-dev