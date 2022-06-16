# syntax=docker/dockerfile:1
FROM php:8.1.7-fpm-buster

WORKDIR /code

# Install dependencies via <apt>

RUN apt update && apt upgrade -y && apt install -y \
        git \
		imagemagick libmagickwand-dev --no-install-recommends \
	&& pecl install imagick \
	&& docker-php-ext-enable imagick

# Install cgi-fcgi via <apt-get>

RUN apt-get update && apt-get install -y \
        libfcgi0ldbl

# Install Composer

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
