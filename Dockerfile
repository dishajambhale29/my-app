# ==============================================================================
# Stage 1: Build Frontend Assets with Node.js & Vite
# ==============================================================================
FROM node:22-alpine AS node_builder

WORKDIR /app

# Copy dependency specifications
COPY package*.json ./

# Install npm dependencies
RUN npm ci || npm install

# Copy source files needed for Vite compilation
COPY . .

# Compile production CSS/JS assets
RUN npm run build

# ==============================================================================
# Stage 2: PHP 8.4 Apache Web Server
# ==============================================================================
FROM php:8.4-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    libsqlite3-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    opcache \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Apache Document Root to Laravel public/ directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy compiled frontend assets from node_builder stage
COPY --from=node_builder /app/public/build ./public/build

# Install production PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Set permissions and make entrypoint executable
RUN chmod +x docker-entrypoint.sh \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose HTTP port (Render uses dynamic $PORT, standard fallback 80)
EXPOSE 80 10000

# Run entrypoint script
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
