FROM php:8.2-apache

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl
    
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json .

RUN composer install

COPY public/ /var/www/html
COPY src/ /var/www/src

EXPOSE 80