FROM php:7.4-fpm

MAINTAINER Evgeniy Panov <panov.eo@gmail.com>

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql

