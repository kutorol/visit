FROM composer:2.4.3 AS composer
FROM php:8.1.0-fpm

WORKDIR /var/www

ARG APCU_VERSION=5.1.18

# Get frequently used tools
RUN apt-get update && apt-get install -y \
    build-essential \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    unzip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl \
    wget \
    zsh \
    libpq-dev

RUN docker-php-ext-configure zip

RUN docker-php-ext-install \
        bcmath \
        mbstring \
        pcntl \
        intl \
        zip \
        opcache \
        pdo \
        pdo_pgsql \
        pgsql

# apcu for caching, xdebug for debugging and also phpunit coverage
RUN pecl install \
        apcu-${APCU_VERSION} \
        xdebug \
    && docker-php-ext-enable \
        apcu \
        xdebug

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN pecl update-channels && pecl install grpc
RUN docker-php-ext-enable grpc

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure non-root user.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

RUN chown -R www-data:www-data /var/www
