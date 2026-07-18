#!/bin/bash
set -e

echo "==> Starting SeminarKu..."

# Buat .env dari .env.example jika belum ada
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Tampilkan variabel DB untuk debug (tanpa password)
echo "==> DB_HOST=${DB_HOST}"
echo "==> DB_PORT=${DB_PORT}"
echo "==> DB_DATABASE=${DB_DATABASE}"
echo "==> DB_USERNAME=${DB_USERNAME}"

# Tunggu MySQL siap (max 60 detik)
echo "==> Waiting for MySQL to be ready..."
MAX_WAIT=60
WAITED=0
until php -r "
    try {
        \$pdo = new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            [PDO::ATTR_TIMEOUT => 3]
        );
        echo 'connected';
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null; do
    if [ $WAITED -ge $MAX_WAIT ]; then
        echo "==> ERROR: MySQL not ready after ${MAX_WAIT}s. Check DB variables."
        exit 1
    fi
    echo "==> MySQL not ready, retrying in 3s... (${WAITED}s elapsed)"
    sleep 3
    WAITED=$((WAITED + 3))
done

echo "==> MySQL is ready!"

# Jalankan migrasi
echo "==> Running migrations..."
php artisan migrate --force

# Jalankan seeder (skip jika data sudah ada)
echo "==> Seeding database..."
php artisan db:seed --class=AdminSeeder --force 2>/dev/null \
    || echo "==> Seeder skipped (data already exists)"

# Clear & cache untuk performa
php artisan config:clear
php artisan view:clear

echo "==> Starting Apache..."
exec apache2-foreground
