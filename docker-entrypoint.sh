#!/bin/sh
set -e

# Configure port for Render (Render passes $PORT, default to 80 if not passed)
PORT="${PORT:-80}"
echo "Configuring Apache to listen on port ${PORT}..."
sed -i -E "s/Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i -E "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/*.conf

# Ensure .env file exists
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        echo "Creating .env from .env.example..."
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# Ensure storage directories exist
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Generate application key if not provided in environment or .env
if [ -z "$APP_KEY" ]; then
    if ! grep -q "^APP_KEY=base64:" /var/www/html/.env 2>/dev/null; then
        echo "Generating Laravel application encryption key..."
        php artisan key:generate --force || true
    fi
fi

# Prepare SQLite database if SQLite connection is used
DB_CONN="${DB_CONNECTION:-sqlite}"
if [ "$DB_CONN" = "sqlite" ]; then
    mkdir -p /var/www/html/database
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        echo "Creating SQLite database file..."
        touch /var/www/html/database/database.sqlite
    fi
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || true

# Seed database with initial products if table is empty
echo "Seeding initial data..."
php artisan db:seed --force || true

# Ensure proper permissions for web server (storage, cache, and database)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Cache routes, views, and configuration for optimal performance
echo "Caching Laravel configuration, routes, and views..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Apache web server on port ${PORT}..."
exec apache2-foreground
