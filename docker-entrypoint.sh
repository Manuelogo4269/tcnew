#!/bin/bash
set -e

PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf 2>/dev/null || true
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true

# Disable Apache default /icons/ alias so /icons/ requests reach Laravel public/icons
sed -ri 's!^(\s*Alias\s+/icons/)!# \1!g' /etc/apache2/mods-available/alias.conf /etc/apache2/mods-enabled/alias.conf 2>/dev/null || true
a2disconf alias 2>/dev/null || true

export DATABASE_URL="${DATABASE_URL:-postgresql://atelier_db_55go_user:ihntg9j5zelCTy2VF6ltL61GZ9qN8VxW@dpg-dai4776k1f9s73bu75fg-a/atelier_db_55go}"

if [ -n "$DATABASE_URL" ]; then
    export DB_CONNECTION="central"
    export CENTRAL_DB_CONNECTION="central"
    export SESSION_CONNECTION="central"
    export DB_CACHE_CONNECTION="central"
    export DB_QUEUE_CONNECTION="central"
else
    export DB_CONNECTION="${DB_CONNECTION:-central}"
    export CENTRAL_DB_CONNECTION="${CENTRAL_DB_CONNECTION:-central}"
    export CENTRAL_DB_DATABASE="${CENTRAL_DB_DATABASE:-database/central.sqlite}"
    export SESSION_CONNECTION="${SESSION_CONNECTION:-central}"
    export DB_CACHE_CONNECTION="${DB_CACHE_CONNECTION:-central}"
    export DB_QUEUE_CONNECTION="${DB_QUEUE_CONNECTION:-central}"
    mkdir -p /var/www/html/database
    touch /var/www/html/database/central.sqlite
    touch /var/www/html/database/database.sqlite
fi

mkdir -p /var/www/html/database
mkdir -p /var/www/html/storage/app/public/products
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/app/private/livewire-tmp
mkdir -p /var/www/html/storage/app/livewire-tmp
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan migrate --force
php artisan tenants:migrate --force || true
php artisan db:seed --force || true
php artisan storage:link || true
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ensure www-data and Apache have full read-write permissions on all directories and SQLite files
chown -R www-data:www-data /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
chmod 666 /var/www/html/database/*.sqlite* 2>/dev/null || true

exec "$@"
