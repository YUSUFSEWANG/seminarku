#!/bin/bash
set -e

APP_PORT=${PORT:-8000}
echo "==> SeminarKu starting on port ${APP_PORT}..."

# Buat .env dari .env.example
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Tunggu MySQL siap
echo "==> Waiting for MySQL (host=${DB_HOST}, port=${DB_PORT})..."
for i in $(seq 1 20); do
    if php -r "
        try {
            new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),
                getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT=>3]);
            exit(0);
        } catch(Exception \$e){ exit(1); }
    " 2>/dev/null; then
        echo "==> MySQL ready!"
        break
    fi
    echo "==> Waiting... attempt ${i}/20"
    sleep 3
done

# Migrasi
echo "==> Running migrations..."
php artisan migrate --force

# Seeder
echo "==> Seeding..."
php artisan db:seed --class=AdminSeeder --force 2>/dev/null \
    || echo "==> Seeder skipped (already seeded)"

# Clear cache
php artisan config:clear 2>/dev/null || true
php artisan view:clear  2>/dev/null || true

# Jalankan PHP built-in server (lebih simpel dari Apache di Railway)
echo "==> Server running at 0.0.0.0:${APP_PORT}"
exec php artisan serve --host=0.0.0.0 --port=${APP_PORT}
