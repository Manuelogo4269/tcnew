#!/bin/bash

PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf 2>/dev/null || true
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/g" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true

# Disable Apache default /icons/ alias so /icons/ requests reach Laravel public/icons
sed -ri 's!^(\s*Alias\s+/icons/)!# \1!g' /etc/apache2/mods-available/alias.conf /etc/apache2/mods-enabled/alias.conf 2>/dev/null || true
a2disconf alias 2>/dev/null || true

export DATABASE_URL="${DATABASE_URL:-postgresql://atelier_db_55go_user:ihntg9j5zelCTy2VF6ltL61GZ9qN8VxW@dpg-dai4776k1f9s73bu75fg-a/atelier_db_55go}"

# Verify if PostgreSQL is actually reachable before forcing its use
USE_SQLITE=0
if [ -n "$DATABASE_URL" ]; then
    echo "Verifying PostgreSQL connection to database..."
    if ! php -r '
        $url = getenv("DATABASE_URL");
        $parts = parse_url($url);
        if (!$parts || !isset($parts["host"])) exit(1);
        $host = $parts["host"];
        $port = $parts["port"] ?? 5432;
        $db = ltrim($parts["path"] ?? "", "/");
        $user = $parts["user"] ?? "";
        $pass = $parts["pass"] ?? "";
        $dsn = "pgsql:host={$host};port={$port};dbname={$db};connect_timeout=4";
        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_TIMEOUT => 4,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            exit(0);
        } catch (\Throwable $e) {
            echo "Notice: PostgreSQL unreachable: " . $e->getMessage() . "\n";
            exit(1);
        }
    ' 2>/dev/null; then
        echo "⚠️ PostgreSQL is unreachable or expired on Render. Gracefully falling back to SQLite to prevent container exit."
        USE_SQLITE=1
        unset DATABASE_URL
    else
        echo "✓ PostgreSQL connection confirmed."
        export DB_CONNECTION="central"
        export CENTRAL_DB_CONNECTION="central"
        export SESSION_CONNECTION="central"
        export DB_CACHE_CONNECTION="central"
        export DB_QUEUE_CONNECTION="central"
    fi
else
    USE_SQLITE=1
fi

if [ "$USE_SQLITE" -eq 1 ]; then
    export DB_CONNECTION="central"
    export CENTRAL_DB_CONNECTION="central"
    export CENTRAL_DB_DATABASE="/var/www/html/database/central.sqlite"
    export SESSION_CONNECTION="central"
    export DB_CACHE_CONNECTION="central"
    export DB_QUEUE_CONNECTION="central"
    mkdir -p /var/www/html/database
    touch /var/www/html/database/central.sqlite
    touch /var/www/html/database/database.sqlite
fi

mkdir -p /var/www/html/database
mkdir -p /var/www/html/storage/app/public/products
mkdir -p /var/www/html/storage/app/public/logos
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/app/private/livewire-tmp
mkdir -p /var/www/html/storage/app/livewire-tmp
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force || true
fi

# Run migrations and seeding without exiting if a table or lock has an issue
php artisan migrate --force || echo "⚠️ Central migrate notice (proceeding)..."
php artisan tenants:migrate --force || true
php artisan db:seed --force || true
php artisan storage:link || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Ensure www-data and Apache have full read-write permissions on all directories and SQLite files
chown -R www-data:www-data /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 777 /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod 666 /var/www/html/database/*.sqlite* 2>/dev/null || true

echo "✓ Starting web server..."
exec "$@"
