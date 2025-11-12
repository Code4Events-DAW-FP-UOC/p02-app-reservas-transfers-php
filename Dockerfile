FROM php:8.1-apache

RUN a2enmod rewrite

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install mysqli

RUN docker-php-ext-install pdo pdo_mysql
