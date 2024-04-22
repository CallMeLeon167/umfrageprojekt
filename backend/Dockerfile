FROM php:8.2-fpm

# Installieren Sie die PDO-Erweiterung
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 9000
CMD ["php-fpm"]