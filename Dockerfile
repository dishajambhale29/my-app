# ==============================================================================
# Laravel Production Dockerfile for Render
# ==============================================================================
FROM php:8.4-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libsqlite3-dev \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    opcache \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer from official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Apache Document Root to Laravel public/ directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy application files (includes pre-built public/build frontend assets)
COPY . .

# Install PHP production dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Make entrypoint executable and prepare directory permissions
RUN chmod +x docker-entrypoint.sh \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose HTTP ports (Render sets $PORT dynamically)
EXPOSE 80 10000

# Execute entrypoint
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
