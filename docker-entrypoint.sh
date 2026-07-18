#!/bin/bash
set -e

echo "==> Starting SeminarKu..."
echo "==> PORT=${PORT:-80}"

# Railway menyediakan PORT secara dinamis, konfigurasi Apache
APP_PORT=${PORT:-80}

# Set Apache listen pada port yang benar
sed -i "s/Listen 80/Listen ${APP_PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80>/:${APP_PORT}>/g" /etc/apache2/sites-available/000-default.conf

echo "==> Apache configured on port ${APP_PORT}"

# Buat .env dari .env.example jika belum ada
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Tunggu MySQL siap (max 60 detik)
echo "==> Waiting for MySQL..."
MAX_WAIT=60
WAITED=0
until php -r "
    try {
        new PDO(
            'mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),
            getenv('DB_USERNAME'), getenv('DB_PASSWORD'),
            [PDO::ATTR_TIMEOUT => 3]
        );
        echo 'ok';
    } catch(Exception \$e) { exit(1); }
" 2>/dev/null; do
    if [ $WAITED -ge $MAX_WAIT ]; then
        echo "==> ERROR: MySQL not ready after ${MAX_WAIT}s"
        exit 1
    fi
    echo "==> Retrying MySQL... (${WAITED}s)"
    sleep 3
    WAITED=$((WAITED+3))
done
echo "==> MySQL ready!"

# Migrasi database
echo "==> Running migrations..."
php artisan migrate --force

# Seeder
php artisan db:seed --class=AdminSeeder --force 2>/dev/null \
    || echo "==> Seeder skipped"

# Clear cache
php artisan config:clear
php artisan view:clear

echo "==> Starting Apache on port ${APP_PORT}..."
exec apache2-foreground
