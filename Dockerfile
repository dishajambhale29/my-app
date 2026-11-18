
FROM php:8.4.18-apache

# Install required system libraries and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    libxml2-dev libicu-dev \
    && docker-php-ext-install \
    pdo pdo_mysql mbstring zip exif pcntl bcmath intl \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN php -v
RUN composer --version
RUN composer install --no-dev --optimize-autoloader -vvv

# Laravel project directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install production dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Configure Apache to serve Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Start Apache on Render's assigned port
CMD ["sh", "-c", "sed -i \"s/Listen 80/Listen ${PORT}/\" /etc/apache2/ports.conf && sed -i \"s/:80>/:${PORT}>/\" /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
