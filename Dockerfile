FROM php:8.4-fpm

# Instala extensões necessárias
RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev zip unzip git curl nodejs npm\
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Cria diretório do socket do PHP-FPM
RUN mkdir -p /run/php

# Permissões
RUN chown -R www-data:www-data /var/www/html

RUN pwd

COPY ./api .

RUN ls -la

RUN composer install

expose 9000

CMD ["php-fpm"]
