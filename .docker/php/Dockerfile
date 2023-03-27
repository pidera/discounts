FROM php:8.2-fpm

RUN apt-get update -y
RUN apt-get install -y git-core curl zip unzip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /app
