FROM php:8.2-apache

# Activa mod_rewrite
RUN a2enmod rewrite

# Cambia el DocumentRoot a public_html
# RUN sed -i 's!/var/www/html!/var/www/public_html!g' /etc/apache2/sites-available/000-default.conf

# Añade AllowOverride All para que .htaccess funcione
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf




