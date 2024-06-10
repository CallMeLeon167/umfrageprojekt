FROM php:8.2-apache

# Install required packages
RUN apt-get update \
    && apt-get install -y git zip unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PDO and Xdebug extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configure Xdebug
RUN echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable mod_rewrite
RUN a2enmod rewrite
# Copy application files
WORKDIR /var/www/html
COPY . /var/www/html

# Set the user to run Composer
RUN chown -R www-data:www-data /var/www/html
USER www-data

# Run composer install
RUN composer install

# Expose port 8000 for Apache
EXPOSE 8000

# Start Apache webserver
CMD "apache2-foreground"