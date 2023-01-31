FROM php:8.1-fpm

RUN mkdir -p /var/www

RUN apt-get update && apt-get install -y \
        curl \
        libpq-dev \
        libicu-dev \
        libzip-dev \
        libxml2-dev \
        zip \
        git && \
        docker-php-ext-install -j$(nproc) iconv intl zip && \
        apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
