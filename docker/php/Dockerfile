FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libmariadb-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader
COPY . .
RUN composer dump-autoload --optimize