# syntax=docker/dockerfile:1
FROM php:8.1.7-fpm-buster

WORKDIR /code

# Install ImageMagick & Imagick via <apt>

RUN apt update && apt upgrade -y && apt install -y --fix-missing \
        zlib1g-dev \
        libzip-dev \
        git \
		imagemagick libmagickwand-dev --no-install-recommends \
	&& pecl install imagick \
    && pecl install pcov \
	&& docker-php-ext-enable imagick \
    && docker-php-ext-install zip \
    && docker-php-ext-enable pcov

# Install cgi-fcgi via <apt-get>

RUN apt-get update && apt-get install -y \
        libfcgi0ldbl

# Install Composer

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
