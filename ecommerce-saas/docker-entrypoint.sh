#!/bin/bash
set -e

# Support dynamic PORT environment variable (Render, Railway use dynamic $PORT)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf 2>/dev/null || true
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true

# Export default database environment variables
export DB_CONNECTION="${DB_CONNECTION:-central}"
export CENTRAL_DB_CONNECTION="${CENTRAL_DB_CONNECTION:-central}"
export CENTRAL_DB_DATABASE="${CENTRAL_DB_DATABASE:-database/central.sqlite}"

# Ensure database directory and SQLite files exist with correct permissions
mkdir -p /var/www/html/database
touch /var/www/html/database/central.sqlite
touch /var/www/html/database/database.sqlite
chown -R www-data:www-data /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache

# Generate APP_KEY if empty
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations and seed iconic Zacatecas stores
php artisan migrate --force
php artisan db:seed --force || true
php artisan storage:link || true
php artisan config:clear
php artisan route:clear
php artisan view:clear

exec "$@"
