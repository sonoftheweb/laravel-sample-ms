FROM php:8.1-apache

RUN apt update \
    && apt install -y \
    g++ \
    libicu-dev \
    libpq-dev \
    zip \
    zlib1g-dev \
    curl \
    unzip \
    && docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_mysql \
    mysqli

WORKDIR /var/www/app
RUN a2enmod rewrite && service apache2 restart
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer