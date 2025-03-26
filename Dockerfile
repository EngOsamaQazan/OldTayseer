# Use an official PHP image with Apache
FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-install intl \
    && echo 'expose_php = Off' >> /usr/local/etc/php/conf.d/security.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy custom Apache configuration
COPY ./docker/000-default.conf /etc/apache2/sites-available/yii2-app.conf
RUN a2ensite yii2-app

# Set working directory to Apache web root
WORKDIR /var/www/html/

# Copy the application code to the container
COPY . .

# Run Composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Run Yii initialization script and automatically select 'JadalDevelopment' environment
RUN php init --env=JadalDevelopment --overwrite=All

# Disable the default site to prevent conflicts
RUN a2dissite 000-default.conf

EXPOSE 80