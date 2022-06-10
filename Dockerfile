# syntax=docker/dockerfile:1
FROM php:8.1-fpm

WORKDIR /code

RUN apt update && apt upgrade -y && apt install -y \
		imagemagick libmagickwand-dev --no-install-recommends \
		git \
	&& pecl install imagick \
	&& docker-php-ext-enable imagick

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
