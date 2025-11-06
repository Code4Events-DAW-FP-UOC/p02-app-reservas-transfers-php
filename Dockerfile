FROM php:8.2-apache
RUN sed -i 's!/var/www/html!/var/www/public_html!g' /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install pdo pdo_mysql
